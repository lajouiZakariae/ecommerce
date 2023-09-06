<?php

namespace App\Http\Resources;

use App\Models\Color;
use App\Models\HasColorMedia;
use App\Models\HasMedia;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "title" => $this->title,
            "price" => $this->price,
            "cost" => $this->cost,
            "quantity" => $this->quantity,
            "createdAt" => $this->created_at,
            "category" => $this->whenLoaded("category"),
            "thumbnail" => $this->whenLoaded("thumbnail"),
            "colors" => $this->whenLoaded("hasColorMedia", function () {
                return $this->hasColorMedia->map(function (HasColorMedia $hasColorMedia) {
                    $color = $hasColorMedia->color;

                    $color->media = MediaResource::collection($hasColorMedia->hasMedia->map(
                        fn (HasMedia $hasMedia) => $hasMedia->media
                    ));

                    return $color;
                });
            }),
        ];
    }
}
