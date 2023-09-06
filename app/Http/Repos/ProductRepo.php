<?php

namespace App\Http\Repos;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class ProductRepo
{
    protected User $user;

    public function __construct()
    {
        $this->user = auth()->user();
    }

    public function index(array $options = [])
    {
        $productQuery = $this->user->products()->with([
            "category:id,name",
            "thumbnail:id,path"
        ]);

        $filteredProducts = $this->filters($productQuery, $options);

        return ProductResource::collection($filteredProducts->paginate());
    }

    protected function filters(Builder|HasManyThrough $q, array $options): Builder|HasManyThrough
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

    public function find($productId)
    {
        $product = $this->user->products()->with([
            "category:id,name,slug",
            "hasColor" => [
                "color:id,hex",
                "hasColorMedia" => [
                    "media:id,path"
                ]
            ]
        ])->find($productId);

        return $product ? new ProductResource($product) : null;
    }

    public function store($data): Product
    {
        /** @var User */
        $user = auth()->user();
        $data["slug"] = \Illuminate\Support\Str::slug($data["title"]);

        if (!isset($data["category_id"]))
            $data["category_id"] = $user->defaultCategory->id;

        $product = new Product($data);
        $product->save();

        return $product;
    }

    function update(int $productId, array $data): bool
    {
        return $this->user->products()->where("products.id", $productId)->update($data);
    }

    function delete($productId): bool
    {
        return $this->user->products()->where("products.id", $productId)->delete();
    }
}
