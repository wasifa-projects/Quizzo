<?php

namespace App\Providers;

use App\Models\User; // Don't forget this!
use Illuminate\Support\Facades\Gate; // And this!
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Define the Admin Gate
        Gate::define('admin-only', function (User $user) {
            return (bool) $user->is_admin;
        });
    }
}