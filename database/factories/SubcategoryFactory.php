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
        $category = $this->getRandomCategoryExceptOne(Category::first());
        return [
            'name' => fake()->word(),
            'slug' => fake()->slug(),
            'description' => fake()->text(),
            'image' => fake()->imageUrl(),
            'order' => fake()->unique()->numberBetween(4, 24),
            'category_id' => $category->id,
        ];
    }

    private function getRandomCategoryExceptOne(Category $categoryToExclude): Category
    {
        $categories = Category::where('id', '<>', $categoryToExclude->id)->get();
        return $categories->random();
    }
}
