<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\MediaController;
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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });


    Route::controller(ProductController::class)->group(function () {

        Route::get("/products", "index");

        Route::get("/products/{product}", "show");

        Route::middleware("can:products.alter")->group(function () {
            Route::post("/products", "store");

            Route::put("/products/{product}", "update");

            Route::delete("/products/{product}", "destroy");
        });

    })->whereNumber("product");

    Route::controller(Media::class)->group(function () {
        Route::get("media", "index");

        Route::post("media", "store")->can("media.create");

    });

    Route::apiResource("/categories", CategoryController::class);

    Route::apiResource("/colors", ColorController::class)->except("show");

    Route::get("/media", [MediaController::class, "index"]);
    Route::post("/media", [MediaController::class, "store"]);
});