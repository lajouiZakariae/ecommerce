<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Gallery extends Model
{
    use HasFactory;

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function subGalleries() : HasMany
    {
        return $this->hasMany(SubGallery::class);
    }

    public function comments() : HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function firstImage() : HasOneThrough
    {
        return $this->hasOneThrough(Image::class, SubGallery::class);
    }
}