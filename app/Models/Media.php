<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Media extends Model
{
    use HasFactory;

    protected $fillable = ["path", "color_id"];

    // protected $hidden = ["pivot"];

    public function products() : BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
}