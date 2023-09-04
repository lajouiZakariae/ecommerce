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
            "category" => $this->category,
            "colors" => $this->HasColorMedias->map(function (HasColorMedia $HasColorMedia): Color {
                $color = $HasColorMedia->color;
                $color->media = MediaResource::collection($HasColorMedia->media);
                return $color;
            }),
            // "colors" => $this->colors,
            // "media" => $this->whenHas("media", MediaResource::collection($this->media)),
            // "thumbnail" => $this->whenHas("thumbnail", $this->thumbnail),
        ];
    }
}
