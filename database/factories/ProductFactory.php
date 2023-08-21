<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

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
        $title = fake()->words(5, true);
        $price = fake()->numberBetween(20, 499);

        return [
            "title" => $title,
            "description" => "",
            "slug" => Str::slug($title),
            "cost" => $price - 10,
            "price" => $price,
            "quantity" => fake()->numberBetween(10, 100),
            // "rating" => Arr::random([1, 1.5, 2, 2.5, 3, 3.5, 4, 4.5, 5], 1)[0],
            "user_id" => 1,
            // "category_id" => fake()->numberBetween(1, 10)
        ];
    }
}