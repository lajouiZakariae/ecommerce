<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function products(array $options)
    {
        return $this
            ->hasMany(Product::class)
            ->when($options["limit"], function (Builder $query) use ($options) {
                $query->take($options["limit"]);
            })
            ->when($options["sortBy"], function (Builder $query) use ($options) {
            })
            ->get(["title", "price", "id"]);
    }

    public function colors(array $options)
    {
        return $this
            ->hasMany(Color::class)
            ->when(isset($options["sortBy"]), function (Builder $query) use ($options) {
                $query->orderBy($options["sortBy"]);
            })
            ->when(isset($options["limit"]), function (Builder $query) use ($options) {
                $query->take($options["limit"]);

            })
            ->get(["name", "hex", "id"]);
    }
}