<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use App\Models\Color;
use App\Models\ColorProduct;
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

        Color::factory(10)->create();

        Category::factory()->create([
            "name" => "Uncatogerized",
            "slug" => "uncatogerized",
            "user_id" => 1
        ]);

        Category::factory(9)->create();

        Product::factory(15)->create();

        ColorProduct::insert(["color_id" => 1, "product_id" => 1]);
        ColorProduct::insert(["color_id" => 2, "product_id" => 1]);
        ColorProduct::insert(["color_id" => 3, "product_id" => 1]);
        ColorProduct::insert(["color_id" => 1, "product_id" => 2]);
        ColorProduct::insert(["color_id" => 2, "product_id" => 2]);
        ColorProduct::insert(["color_id" => 3, "product_id" => 2]);

    }
}