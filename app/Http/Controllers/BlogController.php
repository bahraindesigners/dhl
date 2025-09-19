<?php

namespace App\Http\Controllers;

use App\Helpers\ArabicSearchHelper;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BlogController extends Controller
{
    /**
     * Display a listing of blogs with filtering and search
     */
    public function index(Request $request)
    {
        $query = Blog::published()
            ->with(['category', 'media'])
            ->latest('published_at');

        // Search functionality with Arabic normalization
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $searchTerms = ArabicSearchHelper::createSearchTerms($searchTerm);

            $query->where(function ($q) use ($searchTerms) {
                // Search fields to check
                $fields = [
                    'title->en', 'title->ar',
                    'excerpt->en', 'excerpt->ar',
                    'content->en', 'content->ar',
                    'author',
                ];

                foreach ($searchTerms as $term) {
                    foreach ($fields as $field) {
                        $q->orWhere($field, 'like', "%{$term}%");
                    }
                }
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('blog_category_id', $request->category);
        }

        // Featured filter
        if ($request->filled('featured')) {
            $query->where('featured', $request->boolean('featured'));
        }

        // Sort filter
        $sortBy = $request->get('sort', 'latest');
        switch ($sortBy) {
            case 'oldest':
                $query->oldest('published_at');
                break;
            case 'popular':
                $query->orderBy('views_count', 'desc');
                break;
            case 'alphabetical':
                $query->orderBy('title->en', 'asc');
                break;
            default:
                $query->latest('published_at');
                break;
        }

        // Paginate results
        $blogs = $query->paginate(12)->withQueryString();

        // Transform blog data
        $blogs->getCollection()->transform(function ($blog) {
            return [
                'id' => $blog->id,
                'title' => $blog->title,
                'slug' => $blog->slug,
                'excerpt' => $blog->excerpt,
                'content' => $blog->content,
                'author' => $blog->author,
                'status' => $blog->status,
                'featured' => $blog->featured,
                'show_as_urgent_news' => $blog->show_as_urgent_news,
                'published_at' => $blog->published_at?->toISOString(),
                'views_count' => $blog->views_count ?? 0,
                'reading_time' => $blog->reading_time ?? 5,
                'featured_image' => $blog->getFirstMediaUrl('featured_image'),
                'blog_category' => $blog->category ? [
                    'id' => $blog->category->id,
                    'name' => $blog->category->name,
                    'color' => $blog->category->color,
                ] : null,
            ];
        });

        // Get all categories for filter dropdown
        $categories = BlogCategory::active()
            ->orderBy('name->en')
            ->get()
            ->map(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                ];
            });

        return Inertia::render('Blog/index', [
            'blogs' => $blogs,
            'categories' => $categories,
            'filters' => [
                'search' => $request->search,
                'category' => $request->category,
                'featured' => $request->featured,
                'sort' => $sortBy,
            ],
        ]);
    }

    /**
     * Display the specified blog post
     */
    public function show(Request $request, Blog $blog)
    {
        // Increment view count
        $blog->increment('views_count');

        // Get related blogs (same category, excluding current)
        $relatedBlogs = Blog::published()
            ->where('id', '!=', $blog->id)
            ->where('blog_category_id', $blog->blog_category_id)
            ->with(['category', 'media'])
            ->latest('published_at')
            ->limit(3)
            ->get()
            ->map(function ($relatedBlog) {
                return [
                    'id' => $relatedBlog->id,
                    'title' => $relatedBlog->title,
                    'slug' => $relatedBlog->slug,
                    'excerpt' => $relatedBlog->excerpt,
                    'featured_image' => $relatedBlog->getFirstMediaUrl('featured_image'),
                    'published_at' => $relatedBlog->published_at?->toISOString(),
                    'reading_time' => $relatedBlog->reading_time ?? 5,
                    'blog_category' => $relatedBlog->category ? [
                        'id' => $relatedBlog->category->id,
                        'name' => $relatedBlog->category->name,
                        'color' => $relatedBlog->category->color,
                    ] : null,
                ];
            });

        // Transform blog data
        $blogData = [
            'id' => $blog->id,
            'title' => $blog->title,
            'slug' => $blog->slug,
            'excerpt' => $blog->excerpt,
            'content' => $blog->content,
            'author' => $blog->author,
            'status' => $blog->status,
            'featured' => $blog->featured,
            'show_as_urgent_news' => $blog->show_as_urgent_news,
            'published_at' => $blog->published_at?->toISOString(),
            'views_count' => $blog->views_count ?? 0,
            'reading_time' => $blog->reading_time ?? 5,
            'featured_image' => $blog->getFirstMediaUrl('featured_image'),
            'gallery' => $blog->getMedia('gallery')->map(function ($media) {
                $width = 1200;
                $height = 800;
                
                // Try to get actual image dimensions
                if (in_array($media->mime_type, ['image/jpeg', 'image/png', 'image/gif', 'image/webp'])) {
                    $imagePath = $media->getPath();
                    if (file_exists($imagePath)) {
                        $imageSize = getimagesize($imagePath);
                        if ($imageSize) {
                            $width = $imageSize[0];
                            $height = $imageSize[1];
                        }
                    }
                }
                
                return [
                    'id' => $media->id,
                    'url' => $media->getUrl(),
                    'thumb' => $media->getUrl('thumb'),
                    'alt' => $media->getCustomProperty('alt') ?? '',
                    'width' => $media->getCustomProperty('width') ?? $width,
                    'height' => $media->getCustomProperty('height') ?? $height,
                ];
            }),
            'blog_category' => $blog->category ? [
                'id' => $blog->category->id,
                'name' => $blog->category->name,
                'color' => $blog->category->color,
            ] : null,
        ];

        return Inertia::render('Blog/show', [
            'blog' => $blogData,
            'relatedBlogs' => $relatedBlogs,
        ]);
    }
}
