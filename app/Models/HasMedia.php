<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HasMedia extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function media(): BelongsTo
    {
        return $this->belongsTo(Media::class);
    }
}
