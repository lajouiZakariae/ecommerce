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
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run() : void
    {
        Role::insert(["name" => "admin"]);
        Role::insert(["name" => "content creator"]);
        Role::insert(["name" => "marketer"]);

        \App\Models\User::factory()->createMany([
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

        Category::factory()->create([
            "name" => "Uncatogerized",
            "slug" => "uncatogerized",
            "user_id" => 1
        ]);

        Category::factory(9)->create();

        Product::factory(30)->create();

        Media::insert(["path" => Storage::url("products/default.jpg")]);
        Media::insert(["path" => Storage::url("products/default.svg")]);

        MediaProduct::insert(["product_id" => 1, "media_id" => 1]);
        MediaProduct::insert(["product_id" => 1, "media_id" => 2]);
        MediaProduct::insert(["product_id" => 1, "media_id" => 1]);
        MediaProduct::insert(["product_id" => 1, "media_id" => 2]);


    }
}