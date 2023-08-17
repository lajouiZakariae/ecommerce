<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
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

    }
}