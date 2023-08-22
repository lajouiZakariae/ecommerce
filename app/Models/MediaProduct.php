<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class MediaProduct extends Pivot
{
    use HasFactory;

    protected $table = "media_product";

    public function color(): BelongsTo
    {
        return $this->belongsTo(Color::class);
    }
}