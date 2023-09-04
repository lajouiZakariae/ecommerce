<?php

namespace App\Http\Repos;

use App\Http\Resources\ProductResource;
use App\Models\Color;
use App\Models\Media;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class ProductRepo
{
    public function index(array $options = []) : Collection
    {
        $filteredProducts = $this->filters(
            Product::with(["colors", "category:id,name", "thumbnail:id,path"]),
            $options
        );

        return $filteredProducts->get(["id", "title", "thumbnail", "category_id", "price", "cost", "quantity"]);
    }

    protected function filters(Builder $q, array $options) : Builder
    {
        return $q->when(isset($options["limit"]), function (Builder $query) use ($options) {
            $query->take($options["limit"]);
        })
            ->when(isset($options["sortBy"]), function (Builder $query) use ($options) {
                if ($options["sortBy"] === "latest") {
                    $query->latest();
                } elseif ($options["sortBy"] === "oldest") {
                    $query->oldest();
                } else {
                    $query->orderBy($options["sortBy"]);
                }
            })
            ->when(isset($options["category"]), function (Builder $query) use ($options) {
                $query->where("category_slug", $options["category"]);
            });
    }

    public function find(int $id) : Product
    {
        return Product::with(["colors", "category:id,name"])
            ->find($id, ["id", "title", "slug", "price", "cost", "category_id"]);
    }

    public function store($data) : Product
    {
        /** @var User */
        $user = auth()->user();
        $data["slug"] = \Illuminate\Support\Str::slug($data["title"]);

        if (! isset($data["category_id"]))
            $data["category_id"] = $user->defaultCategory->id;

        $product = new Product($data);
        $product->save();

        return $product;
    }

    function update(int $productId, array $data) : bool
    {
        return Product::whereId($productId)->update($data);
    }

    function delete($productId) : bool
    {
        return Product::whereId($productId)->delete();
    }
}