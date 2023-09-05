<?php

namespace App\Http\Resources;

use App\Models\Color;
use App\Models\HasColorMedia;
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
            "category" => $this->whenHas("category", $this->category),
            "createdAt" => $this->created_at,
            "colors" => $this->hasColorMedia->map(function (HasColorMedia $hasColorMedia): Color {
                $color = $hasColorMedia->color;
                $color->media = MediaResource::collection($hasColorMedia->media);
                return $color;
            }),
            // "media" => $this->whenHas("media", MediaResource::collection($this->media)),
            // "thumbnail" => $this->whenHas("thumbnail", $this->thumbnail),
        ];
    }
}
