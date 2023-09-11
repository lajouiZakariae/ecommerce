<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use App\Models\Color;
use App\Models\HasColor;
use App\Models\HasColorMedia;
use App\Models\HasMedia;
use App\Models\Media;
use App\Models\Product;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::insert([
            ["name" => "admin"],
            ["name" => "content creator"],
            ["name" => "marketer"],
        ]);

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

        Color::factory(15)->for($users[0])->create();

        // Media::factory(24)->for($users[0])->create();
        collect(Storage::disk("public")->files("products"))->each(function (string  $file) use ($users) {
            Media::insert(["path" => ($file), "user_id" => $users[0]->id]);
        });

        for ($i = 1; $i < 4; $i++) {
            $hasColorMedia = HasColor::create([
                "product_id" => 1,
                "color_id" => $i
            ]);

            for ($j = 1; $j < 5; $j++) {
                HasColorMedia::insert([
                    "has_color_id" => $hasColorMedia->id,
                    "media_id" => $j * $i
                ]);
            }
        }
    }
}
