<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
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
                "sortBy" => $request->input("sortBy"),
                "category" => $request->input("category")
            ],
            [
                "limit" => "numeric|max:10",
                "sortBy" => Rule::in(["cost", "price", "quantity"]),
            ]
        )->valid();

        return $user->products()
            // ->with("media")
            ->when(isset($options["limit"]), function (Builder $query) use ($options) {
                $query->take($options["limit"]);
            })
            ->when(isset($options["sortBy"]), function (Builder $query) use ($options) {
                $query->orderBy($options["sortBy"]);
            })
            ->when(isset($options["category"]), function (Builder $query) use ($options) {
                $query->where("category_id", $options["category"]);
            })
            ->orderBy("id", "desc")
            ->get(["title", "price", "id"]);
    }

    public function store(Request $request)
    {
        $user = User::find(1);

        $data = Validator::make($request->all(), [
            "title" => "required",
            "price" => "float",
            "cost" => "float",
            "quantity" => "integer",
            "category_id" => "integer"
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

        return $user
            ->products()
            ->with("media:id,path")
            ->with("category:id,name,slug")
            ->find($id, ["id", "title", "slug", "price", "cost", "category_id"]);
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