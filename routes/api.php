<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\ProductController;
use App\Models\Color;
use App\Models\Media;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get("/user", fn() => User::find(1));

Route::apiResource("/products", ProductController::class)->name("index", "products");

Route::apiResource("/categories", CategoryController::class)->name("index", "products");

Route::apiResource("/colors", ColorController::class)->name("index", "colors")->except("show");

Route::get("/media", function () {
    return Media::all()->each(function ($media): Media {
        $media->path = Storage::url($media->path);
        return $media;
    });
});

Route::post("/media", function (Request $request) {
    $user = User::find(1);

    $image = $request->file("image");

    Validator::make($request->all(), [
        "image" => ["required", "image"]
    ])->validate();

    $path = $image->store("media", "public");

    $media = new Media([
        "path" => $path,
        "user_id" => $user->id,
    ]);

    $media->save();

    return Storage::url($media->path);
});