<?php

namespace App\Http\Controllers;

use App\Http\Repos\ProductRepo;
use App\Http\Requests\ProductPostRequest;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
                "sortBy" => Rule::in(["cost", "price", "quantity", "latest", "oldest"]),
            ]
        )->valid();

        return $this->products->index($options);
    }

    public function store(ProductPostRequest $request)
    {
        $data = $request->validated();

        $product = new Product($data);
        // Validate if user has the category included & include defaultCategory() if category not provided

        $product->save();

        return response()
            ->make($product, 201)
            ->header("Location", route("products.show", ["product" => $product->id]));
    }

    public function show($productId)
    {
        return $this->products->find($productId) ?? abort(404);
    }

    public function update(ProductPostRequest $request, int $productId)
    {
        $data = $request->validated();

        return response()
            ->make("", $this->products->update($productId, $data) ? 204 : 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($productId)
    {
        return $this->products->delete($productId) ? response()->noContent() : abort(404);
    }
}
