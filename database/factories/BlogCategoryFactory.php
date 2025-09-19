<?php

namespace Database\Factories;

use App\Models\BlogCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BlogCategory>
 */
class BlogCategoryFactory extends Factory
{
    protected $model = BlogCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $nameEn = fake()->words(2, true);
        $nameAr = fake()->sentence(2);

        return [
            'name' => [
                'en' => $nameEn,
                'ar' => $nameAr,
            ],
            'slug' => [
                'en' => Str::slug($nameEn),
                'ar' => Str::slug($nameAr),
            ],
            'description' => [
                'en' => fake()->paragraph(),
                'ar' => fake()->paragraph(),
            ],
            'sort_order' => fake()->numberBetween(1, 100),
            'status' => 'active',
        ];
    }

    /**
     * Indicate that the blog category is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'inactive',
        ]);
    }
}
