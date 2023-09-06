<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ["title", "slug", "cost", "quantity", "price", "category_id", "thumbnail"];

    protected $perPage = 10;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function thumbnail(): BelongsTo
    {
        return $this->belongsTo(Media::class, "thumbnail_id", "id");
    }

    public function hasColorMedia()
    {
        return $this->hasMany(HasColorMedia::class, "product_id");
    }

    public function media()
    {
        return $this->belongsToMany(Media::class)->withPivot("order");
    }

    public function colors(): BelongsToMany
    {
        return $this->belongsToMany(Color::class);
    }
}
