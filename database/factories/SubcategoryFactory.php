<?php

namespace Database\Factories;

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
        $category = CategoryFactory::new()->create();
        return [
            'name' => fake()->word(),
            'slug' => fake()->slug(),
            'description' => fake()->text(),
            'image' => fake()->imageUrl(),
            'order' => fake()->numberBetween(0, 100),
            'category_id' => $category->id,
        ];
    }
}
