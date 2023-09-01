<?php

namespace App\Http\Repos;

use App\Models\Color;
use App\Models\Media;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class ProductRepo
{
    public function index(array $options = [])
    {
        return Product::when(isset($options["limit"]), function (Builder $query) use ($options) {
            $query->take($options["limit"]);
        })
            ->when(isset($options["sortBy"]), function (Builder $query) use ($options) {
                $query->orderBy($options["sortBy"]);
            })
            ->when(isset($options["category"]), function (Builder $query) use ($options) {
                $query->where("category_slug", $options["category"]);
            })
            ->paginate();

        // return $query->with("media")->get();
    }

    public function store($data)
    {
        /** @var User */
        $user = auth()->user();
        $data["slug"] = \Illuminate\Support\Str::slug($data["title"]);

        if (! isset($data["category_id"]))
            $data["category_id"] = $user->defaultCategory->id;

        $product = new Product($data);

        // return $product;

        $product->save();
        return $product;
    }

    public function find(int $id)
    {
        $product = Product::whereId($id)
            ->find($id, ["id", "title", "slug", "price", "cost", "category_id"]);


        return $product;
    }

}