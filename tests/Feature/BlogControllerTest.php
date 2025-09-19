<?php

use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Create a blog category
    $this->category = BlogCategory::factory()->create([
        'name' => ['en' => 'Technology', 'ar' => 'التقنية'],
        'slug' => ['en' => 'technology', 'ar' => 'التقنية'],
    ]);

    // Create some test blogs
    $this->featuredBlog = Blog::factory()->create([
        'title' => ['en' => 'Featured Tech Article', 'ar' => 'مقال تقني مميز'],
        'slug' => ['en' => 'featured-tech-article', 'ar' => 'مقال-تقني-مميز'],
        'excerpt' => ['en' => 'This is a featured article about technology', 'ar' => 'هذا مقال مميز عن التقنية'],
        'content' => ['en' => 'Full content of the tech article', 'ar' => 'المحتوى الكامل للمقال التقني'],
        'blog_category_id' => $this->category->id,
        'featured' => true,
        'status' => 'published',
        'published_at' => now(),
        'views_count' => 100,
    ]);

    $this->regularBlog = Blog::factory()->create([
        'title' => ['en' => 'Regular Article', 'ar' => 'مقال عادي'],
        'slug' => ['en' => 'regular-article', 'ar' => 'مقال-عادي'],
        'excerpt' => ['en' => 'This is a regular article', 'ar' => 'هذا مقال عادي'],
        'content' => ['en' => 'Full content of the regular article', 'ar' => 'المحتوى الكامل للمقال العادي'],
        'blog_category_id' => $this->category->id,
        'featured' => false,
        'status' => 'published',
        'published_at' => now()->subDay(),
        'views_count' => 50,
    ]);
});

it('displays the blog index page', function () {
    $response = $this->get('/news');

    $response->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('Blog/index')
            ->has('blogs.data', 2)
            ->has('categories')
            ->where('filters', [
                'search' => null,
                'category' => null,
                'featured' => null,
                'sort' => 'latest',
            ])
        );
});

it('filters blogs by search term', function () {
    $response = $this->get('/news?search=Featured');

    $response->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('Blog/index')
            ->has('blogs.data', 1)
            ->where('blogs.data.0.title', 'Featured Tech Article')
        );
});

it('filters blogs by category', function () {
    $response = $this->get('/news?category='.$this->category->id);

    $response->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('Blog/index')
            ->has('blogs.data', 2)
        );
});

it('filters featured blogs only', function () {
    $response = $this->get('/news?featured=1');

    $response->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('Blog/index')
            ->has('blogs.data', 1)
            ->where('blogs.data.0.featured', true)
        );
});

it('sorts blogs by latest', function () {
    $response = $this->get('/news?sort=latest');

    $response->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('Blog/index')
            ->has('blogs.data', 2)
            ->where('blogs.data.0.title', 'Featured Tech Article') // Should be first (newer)
        );
});

it('sorts blogs by popular', function () {
    $response = $this->get('/news?sort=popular');

    $response->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('Blog/index')
            ->has('blogs.data', 2)
            ->where('blogs.data.0.title', 'Featured Tech Article') // Should be first (more views)
        );
});

it('displays a single blog post', function () {
    $response = $this->get('/news/'.$this->featuredBlog->id);

    $response->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('Blog/show')
            ->where('blog.title', 'Featured Tech Article')
            ->has('relatedBlogs')
        );
});

it('increments view count when viewing a blog', function () {
    $initialViews = $this->featuredBlog->views_count;

    $this->get('/news/'.$this->featuredBlog->id);

    $this->featuredBlog->refresh();
    expect($this->featuredBlog->views_count)->toBe($initialViews + 1);
});

it('shows related blogs based on same category', function () {
    // Create another blog in the same category
    $relatedBlog = Blog::factory()->create([
        'title' => ['en' => 'Another Tech Article', 'ar' => 'مقال تقني آخر'],
        'slug' => ['en' => 'another-tech-article', 'ar' => 'مقال-تقني-آخر'],
        'blog_category_id' => $this->category->id,
        'status' => 'published',
        'published_at' => now()->subDays(2),
    ]);

    $response = $this->get('/news/'.$this->featuredBlog->id);

    $response->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('Blog/show')
            ->has('relatedBlogs', 2) // Should include regularBlog and relatedBlog
        );
});

it('handles multilingual search in Arabic', function () {
    $response = $this->get('/news?'.http_build_query(['search' => 'مميز']));

    $response->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('Blog/index')
            ->has('blogs.data', 1)
            ->where('blogs.data.0.title', 'Featured Tech Article')
        );
});

it('returns 404 for non-existent blog', function () {
    $response = $this->get('/news/non-existent-slug');

    $response->assertNotFound();
});

it('only shows published blogs', function () {
    // Create a draft blog
    Blog::factory()->create([
        'title' => ['en' => 'Draft Article', 'ar' => 'مقال مسودة'],
        'slug' => ['en' => 'draft-article', 'ar' => 'مقال-مسودة'],
        'status' => 'draft',
    ]);

    $response = $this->get('/news');

    $response->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('Blog/index')
            ->has('blogs.data', 2) // Should only show the 2 published blogs
        );
});

it('paginates blog results', function () {
    // Create 15 additional blogs to test pagination
    Blog::factory()->count(15)->create([
        'blog_category_id' => $this->category->id,
        'status' => 'published',
        'published_at' => now(),
    ]);

    $response = $this->get('/news');

    $response->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('Blog/index')
            ->has('blogs.data', 12) // Should show 12 per page
            ->has('blogs.links')
        );
});
