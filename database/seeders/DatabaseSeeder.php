<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use App\Models\Color;
use App\Models\ColorProduct;
use App\Models\Media;
use App\Models\MediaProduct;
use App\Models\Product;
use App\Models\ProductColors;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        $user = new \App\Models\User([
            'name' => 'User One',
            'email' => 'user@one.com',
            'password' => Hash::make('1234'),
        ]);

        $user->save();

        Category::factory()->create([
            "name" => "Uncatogerized",
            "slug" => "uncatogerized",
            "user_id" => 1
        ]);

        $result = Category::factory(9)->create();

        $result->each(function (Category $category): void {
            $title = fake()->words(5, true);
            $price = fake()->numberBetween(20, 499);

            Product::factory()->create([
                "title" => $title,
                "description" => "",
                "slug" => \Illuminate\Support\Str::slug($title),
                "cost" => $price - 10,
                "price" => $price,
                "quantity" => fake()->numberBetween(10, 100),
                // "rating" => Arr::random([1, 1.5, 2, 2.5, 3, 3.5, 4, 4.5, 5], 1)[0],
                "user_id" => 1,
                "category_slug" => $category->slug
                // "category_id" => fake()->numberBetween(1, 10)

            ]);

        });

        Media::factory(15)->create();

        MediaProduct::insert(["product_id" => 1, "media_id" => 1, "color_id" => 1]);
        MediaProduct::insert(["product_id" => 1, "media_id" => 2, "color_id" => 2]);

        Color::factory(10)->create();

    }
}