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
        $user = User::find(1);

        /** @var Builder */
        $query = Product::whereBelongsTo($user);

        $products = $query
            ->when(isset($options["limit"]), function (Builder $query) use ($options) {
                $query->take($options["limit"]);
            })
            ->when(isset($options["sortBy"]), function (Builder $query) use ($options) {
                $query->orderBy($options["sortBy"]);
            })
            ->when(isset($options["category"]), function (Builder $query) use ($options) {
                $query->where("category_slug", $options["category"]);
            })
            ->with("media:id,path")
            ->orderByDesc("id")
            ->get(["id", "title", "price"]);

        $products->each(
            fn(Product $product) => $product->media->each(
                fn(Media $media) => $media->pivot->color
            )
        );

        return $products;
    }

    public function store($data)
    {
        $user = User::find(1);
        $data["user_id"] = $user->id;
        $data["slug"] = \Illuminate\Support\Str::slug($data["title"]);

        if (!isset($data["category_id"]))
            $data["category_id"] = $user->defaultCategoryId();

        $product = new Product($data);

        return ["created" => $product->save()];
    }

    public function find(int $id)
    {
        $user = User::find(1);

        /** @var Builder */
        $query = Product::whereBelongsTo($user);
        return $query
            ->with("media:id,path")
            ->with("category:id,name,slug")
            ->find($id, ["id", "title", "slug", "price", "cost", "category_slug"]);
    }

}