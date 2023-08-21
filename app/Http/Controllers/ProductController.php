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
        $data = Validator::make($request->all(), [
            "title" => "required",
            "price" => "float",
            "cost" => "float",
            "quantity" => "integer",
            "category_id" => "integer"
        ])->validate();

        $this->products->store($data);
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