<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subcategory>
 */
class SubcategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        
        return [
            'name' => fake()->word(),
            'slug' => fake()->slug(),
            'description' => fake()->text(),
            'image' => fake()->imageUrl(),
            'order' => fake()->unique()->numberBetween(4, 24),
            'category_id' => Category::factory()->create()->id,
        ];
    }

    private function getRandomCategoryExceptOne(Category $categoryToExclude): Category
    {
        $categories = Category::where('id', '<>', $categoryToExclude->id)->get();
        return $categories->random();
    }
}
