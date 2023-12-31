<?php

namespace App\Http\Repos;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Facades\Auth;

class ProductRepo
{
    protected User $user;

    public function index(array $options = [])
    {
        $productQuery = request()->user()->products()->with([
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
        $product = request()->user()->products()->with([
            "category:id,name,slug",
            "hasColors" => [
                "color",
                "hasColorMedia" => [
                    "media:id,path"
                ]
            ]
        ])->find($productId);

        return $product ? new ProductResource($product) : null;
    }

    public function create($data): Product
    {
        $product = new Product($data);

        if (!isset($product["category_id"])) {
            $product["category_id"] = request()->user()->defaultCategory->id;
        }

        $product->save();

        return $product;
    }

    function update(int $productId, array $data): bool
    {
        return request()->user()->products()->where("products.id", $productId)->update($data);
    }

    function delete($productId): bool
    {
        return request()->user()->products()->where("products.id", $productId)->delete();
    }
}
