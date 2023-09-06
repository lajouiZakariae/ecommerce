<?php

namespace App\Http\Resources;

use App\Models\Color;
use App\Models\HasColor;
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
            "colors" => $this->whenLoaded("hasColor", function () {
                return $this->hasColor->map(function (HasColor $hasColor) {
                    $color = $hasColor->color;

                    $color->media = MediaResource::collection($hasColor->hasColorMedia->map(
                        fn (HasColorMedia $hasColorMedia) => $hasColorMedia->media
                    ));

                    return $color;
                });
            }),
        ];
    }
}
