<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $user = User::find(1);

        $options = Validator::make(
            [
                "limit" => $request->input("limit"),
                "sortBy" => $request->input("sortBy")
            ],
            [
                "limit" => "numeric|max:10",
                "sortBy" => Rule::in(["cost", "price", "quantity"]),
            ]
        )->valid();


        return $user->products($options);
    }

    public function store(Request $request)
    {
        $user = User::find(1);

        $data = Validator::make($request->all(), [
            "title" => "required",
            "price" => "float"
        ])->validate();

        $data["user_id"] = $user->id;
        $data["slug"] = \Illuminate\Support\Str::slug($data["title"]);

        if (!isset($data["category_id"]))
            $data["category_id"] = $user->defaultCategoryId();

        return ["created" => Product::insert($data)];
    }

    public function show($id)
    {
        $user = User::find(1);
        $product = $user->product($id);

        if (!$product) {
            return response("", 404);
        }

        $product["colors"] = $product->colors()->map(function ($color) {
            return ["hex" => $color->hex, "name" => $color->name, "id" => $color->id];
        });

        return $product;
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