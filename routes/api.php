<?php

use App\Http\Controllers\ColorController;
use App\Http\Controllers\ProductController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

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

Route::apiResource("/colors", ColorController::class)->name("index", "colors")->except("show");