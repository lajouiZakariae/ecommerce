<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use App\Models\Color;
use App\Models\HasColorMedia;
use App\Models\Media;
use App\Models\Product;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::insert(["name" => "admin"]);
        Role::insert(["name" => "content creator"]);
        Role::insert(["name" => "marketer"]);

        $users = User::factory()->createMany([
            [
                'name' => 'User One',
                'email' => 'user@one.com',
                'password' => Hash::make('password'),
                "role_id" => \App\Enums\Role::ADMIN
            ],
            [
                'name' => 'User Two',
                'email' => 'user@two.com',
                'password' => Hash::make('password'),
                "role_id" => \App\Enums\Role::CONTENT_CREATOR
            ],
            [
                'name' => 'User Three',
                'email' => 'user@three.com',
                'password' => Hash::make('password'),
                "role_id" => \App\Enums\Role::MARKETER
            ],
        ]);

        $users->each(function (User $user) {
            Category::insert(["name" => "default", "slug" => "default", "user_id" => $user->id]);
        });

        $categories = Category::factory(3)->for($users[0])->create();

        $categories->each(fn (Category $category) => Product::factory(4)->for($category)->create());

        Color::factory(4)->create();

        for ($i = 1; $i < 4; $i++) {
            HasColorMedia::insert([
                "product_id" => 1,
                "color_id" => $i
            ]);
        }

        for ($i = 1; $i < 4; $i++) {

            Media::insert([
                "has_color_media_id" => $i,
                "path" => fake()->image("storage/app/public/products", 500, 500, null, true)
            ]);
            Media::insert([
                "has_color_media_id" => $i,
                "path" => fake()->image("storage/app/public/products", 500, 500, null, true)
            ]);
        }
    }
}
