<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\PendingHasThroughRelationship;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ["title", "slug", "cost", "quantity", "price"];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, "category_slug", "slug");
    }

    public function colors(): BelongsToMany
    {
        return $this->belongsToMany(Color::class);
    }


    public function media(): BelongsToMany
    {
        return $this->belongsToMany(Media::class)->withPivot("color_id");
    }

}