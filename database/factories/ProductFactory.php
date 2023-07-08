<?php

namespace Database\Factories;

use App\Models\Subcategory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $subcategory_id = Subcategory::all()->random()->id;
        $name = fake()->unique()->word() . ' ' . fake()->word() . ' ' . fake()->word();
        return [
            'name' => $name,
            'slug' => Str::of($name)->slug('-'),
            'description' => fake()->sentence(),
            'image' => 'products/add-image.png',
            'price' => fake()->randomFloat(2, 1, 1000),
            'stock' => fake()->numberBetween(1, 100),
            'order' => fake()->unique()->numberBetween(0, 1000),
            'subcategory_id' => $subcategory_id,
        ];
    }
}
