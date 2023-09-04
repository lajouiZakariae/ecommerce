<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use App\Models\Color;
use App\Models\Comment;
use App\Models\Gallery;
use App\Models\HasColorMedia;
use App\Models\Image;
use App\Models\Media;
use App\Models\Product;
use App\Models\Role;
use App\Models\SubGallery;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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

        [$user] = User::factory()->createMany([
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

        // Category::factory()->create([
        //     "name" => "Uncatogerized",
        //     "slug" => "uncatogerized",
        //     "user_id" => 1
        // ]);

        // Category::factory(9)->create();

        // Media::insert(["path" => Storage::url("products/default.jpg")]);
        // Media::insert(["path" => Storage::url("products/default.svg")]);

        // Product::factory(30)->create();t(["product_id" => 1, "media_id" => 1]);
        // DB::table("media_product")->inser

        // DB::table("media_product")->insert(["product_id" => 1, "media_id" => 2]);
        // DB::table("media_product")->insert(["product_id" => 1, "media_id" => 1]);
        // DB::table("media_product")->insert(["product_id" => 1, "media_id" => 2]);

        // Color::factory(10)->create();

        // DB::table("color_product")->insert(["product_id" => 1, "color_id" => 1]);
        // DB::table("color_product")->insert(["product_id" => 1, "color_id" => 2]);
        // DB::table("color_product")->insert(["product_id" => 1, "color_id" => 3]);

        // $galleries = Gallery::factory(4)->for($user)->create();

        // $galleries->each(fn (Gallery $gallery) => SubGallery::factory(5)->for($gallery)->create());

        $user = User::factory()->has(Gallery::factory()->count(4), "galleries")->create([
            "email" => "user@four.com",
            "password" => Hash::make("password"),
        ]);

        // $user->galleries->each(

        //     function (Gallery $gallery) {
        //         Comment::factory(4)->for($gallery)->create();

        //         $subGalleries = SubGallery::factory(4)->for($gallery)->create();

        //         $subGalleries->each(
        //             function (SubGallery $subGallery): void {
        //                 Image::factory(4)->for($subGallery)->create();
        //             }
        //         );
        //     }

        // );

        // ADDED

        $categories = Category::factory(3)->create();
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
                "has_media_color_id" => $i,
                "path" => fake()->image("storage/app/public/products", 500, 500, null, true)
            ]);
            Media::insert([
                "has_media_color_id" => $i,
                "path" => fake()->image("storage/app/public/products", 500, 500, null, true)
            ]);
        }
    }
}
