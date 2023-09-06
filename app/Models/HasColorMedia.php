<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HasColorMedia extends Model
{
    use HasFactory;

    protected $table = "has_color_media";

    public $timestamps = false;

    public function media(): BelongsTo
    {
        return $this->belongsTo(Media::class);
    }
}
