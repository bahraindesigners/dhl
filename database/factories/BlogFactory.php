<?php

namespace Database\Factories;

use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
class BlogFactory extends Factory
{
    protected $model = Blog::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $titleEn = fake()->sentence(3);
        $titleAr = fake()->sentence(3);

        return [
            'title' => [
                'en' => $titleEn,
                'ar' => $titleAr,
            ],
            'slug' => [
                'en' => Str::slug($titleEn).'-'.fake()->randomNumber(4),
                'ar' => Str::slug($titleAr).'-'.fake()->randomNumber(4),
            ],
            'excerpt' => [
                'en' => fake()->paragraph(2),
                'ar' => fake()->paragraph(2),
            ],
            'content' => [
                'en' => fake()->paragraphs(5, true),
                'ar' => fake()->paragraphs(5, true),
            ],
            'author' => fake()->name(),
            'status' => 'published',
            'featured' => fake()->boolean(20), // 20% chance of being featured
            'show_as_urgent_news' => fake()->boolean(10), // 10% chance of being urgent
            'published_at' => fake()->dateTimeBetween('-1 year', 'now'),
            'views_count' => fake()->numberBetween(0, 1000),
            'reading_time' => fake()->numberBetween(1, 15),
            'blog_category_id' => BlogCategory::factory(),
        ];
    }

    /**
     * Indicate that the blog is featured.
     */
    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'featured' => true,
        ]);
    }

    /**
     * Indicate that the blog is urgent news.
     */
    public function urgent(): static
    {
        return $this->state(fn (array $attributes) => [
            'show_as_urgent_news' => true,
        ]);
    }

    /**
     * Indicate that the blog is a draft.
     */
    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'draft',
            'published_at' => null,
        ]);
    }

    /**
     * Indicate that the blog is popular (high views).
     */
    public function popular(): static
    {
        return $this->state(fn (array $attributes) => [
            'views_count' => fake()->numberBetween(500, 2000),
        ]);
    }
}
