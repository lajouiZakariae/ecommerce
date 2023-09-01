<?php

namespace App\Http\Controllers;

use App\Http\Repos\ProductRepo;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;

class ProductController extends Controller
{
    public function __construct(public ProductRepo $products)
    {
    }

    public function index(Request $request)
    {

        $options = Validator::make(
            [
                "limit" => $request->input("limit"),
                "sortBy" => $request->input("sortBy"),
                "category" => $request->input("category")
            ],
            [
                "limit" => "numeric|max:10",
                "sortBy" => Rule::in(["cost", "price", "quantity"]),
            ]
        )->valid();

        return $this->products->index($options);
    }

    public function store(Request $request)
    {
        $request->merge(["slug" => str()->slug($request->input("title"))]);

        $data = $request->validate([
            "title" => "required",
            "slug" => ["required", "unique:products"],
            "price" => "numeric",
            "cost" => "numeric",
            "quantity" => "integer",
            "category_id" => "integer"
        ]);

        return "Yes You Can";
        return response()
            ->make($this->products->store($data), 201)
            ->header("Location", route("products.index"));
    }

    public function show($id)
    {
        return $this->products->find($id);
    }

    public function update(Request $request, Product $product)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        return ["deleted" => $product->delete()];
    }
}