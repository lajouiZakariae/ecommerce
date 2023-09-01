<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Concerns\InteractsWithPivotTable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Ramsey\Uuid\Exception\BuilderNotFoundException;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ["title", "slug", "cost", "quantity", "price", "category_id"];

    protected $perPage = 10;

    // public function user(): BelongsTo
    // {
    //     return $this->belongsTo(User::class);
    // }

    public function category() : BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function media() : HasMany
    {
        return $this->hasMany(Media::class);
    }
}