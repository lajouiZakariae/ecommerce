<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubGallery extends Model
{
    use HasFactory;

    public function gallery() : BelongsTo
    {
        return $this->belongsTo(Gallery::class);
    }


    public function images() : HasMany
    {
        return $this->hasMany(Image::class);
    }
}