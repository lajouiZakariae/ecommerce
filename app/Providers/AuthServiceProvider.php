<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Enums\Role;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        auth()->loginUsingId(1);

        Gate::define(
            "categories.alter",
            fn (User $user) => in_array($user->role->id, [Role::ADMIN, Role::CONTENT_CREATOR])
        );

        Gate::define(
            "products.alter",
            fn (User $user) => in_array($user->role->id, [Role::ADMIN, Role::CONTENT_CREATOR])
        );
    }
}
