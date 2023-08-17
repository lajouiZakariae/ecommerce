<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;

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
        $user = User::find(1);

        $data = Validator::make($request->all(), [
            "title" => "required",
            "price" => "float"
        ])->validate();

        $data["slug"] = \Illuminate\Support\Str::slug($data["title"]);
        $data["user_id"] = $user->id;
        $data["category_id"] = $user->defaultCategoryId();

        return ["created" => Product::insert($data)];
    }

    public function show(Product $product)
    {
        return $product
            ->only("title", "cost", "price", "quantity");
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