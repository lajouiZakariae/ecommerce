<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\ProductController;
use App\Http\Resources\MediaResource;
use App\Http\Resources\ProductResource;
use App\Models\Color;
use App\Models\Media;
use App\Models\Product;
use App\Models\User;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Support\Benchmark;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Expr\FuncCall;

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

    Route::group([
        "prefix" => "products",
        "as" => "products.",
        "controller" => ProductController::class
    ], function () {
        Route::get("/", "index")->name("index");

        Route::get("/{product}", "show")->name("show");

        Route::middleware("can:products.alter")->group(function () {

            Route::post("/", "store")->name("create");

            Route::put("/{product}", "update")->name("update");

            Route::delete("/{product}", "destroy")->name("delete");
        });
    })->whereNumber("product");

    Route::group([
        "prefix" => "categories",
        "as" => "categories.",
        "controller" => CategoryController::class
    ], function () {
        Route::get("/", "index");

        Route::get("/{category}", "show");

        Route::middleware("can:categories.alter")->group(function () {
            Route::post("/", "store");

            Route::put("/{category}", "update");

            Route::delete("/{category}", "destroy");
        });

        Route::middleware("can:products.alter")->group(function () {
            Route::get("/{category}/products", "products");

            Route::post("/{category}/products", "storeProduct");
        });
    });

    Route::group([
        "controller" => ColorController::class,
        "prefix" => "colors",
        "as" => "colors."
    ], function () {
        Route::get("/", "index");

        Route::middleware("can:colors.alter")->group(function (): void {
            Route::post("/", "store");

            Route::delete("/{color}", "destroy");

            Route::put("/{color}", "update");
        });
    });

    Route::controller(MediaController::class)->group(function () {
        Route::get("media", "index");

        Route::post("media", "store")->can("media.create");
    });

    Route::get("/test", function (Request $request) {
        return $request->getAcceptableContentTypes();
    });
});
