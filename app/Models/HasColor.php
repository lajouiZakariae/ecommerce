<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HasColor extends Model
{
    use HasFactory;

    protected $table = "has_color";

    public $timestamps = false;

    public function color(): BelongsTo
    {
        return $this->belongsTo(Color::class);
    }

    public function hasColorMedia(): HasMany
    {
        return $this->hasMany(HasColorMedia::class, "has_color_id");
    }
}
