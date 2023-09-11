<?php

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::post("login", function (Request $request) {
    if (auth("web")->attempt([
        "email" => $request->input("email"),
        "password" => $request->input("password")
    ])) {
        $request->session()->regenerate();
        return $request->user();
    }
});

Route::view('/dashboard/{path?}', 'welcome')
    ->where('path', '.*');

Route::get("/", function (): View {
    return view("index");
});
