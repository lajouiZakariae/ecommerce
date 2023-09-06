<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HasColorMedia extends Model
{
    use HasFactory;

    protected $table = "has_color_media";
    public $timestamps = false;

    public function color(): BelongsTo
    {
        return $this->belongsTo(Color::class);
    }

    public function hasMedia(): HasMany
    {
        return $this->hasMany(HasMedia::class, "has_color_media_id");
    }
}
