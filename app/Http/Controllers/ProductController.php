<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $user = User::find(1);

        $options = [
            "limit" => $request->input("limit"),
            "sortBy" => $request->input("sortBy"),
        ];

        return ["products" => $user->products($options), "route" => route("products")];
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Product $product)
    {
        return $product->only("title", "cost", "price", "rating");
    }

    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        return ["deleted" => $product->delete()];
    }
}