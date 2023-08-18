<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ["title", "slug", "cost", "quantity", "price"];

    public function colors(): Collection
    {
        return $this->belongsToMany(Color::class)->get(["colors.id", "name", "hex"]);
    }

}