<?php

namespace App\Providers;

use App\Contracts\AuthInterface;
use App\Contracts\Mosque\ProfileInterface;
use App\Repositories\AuthRepository;
use App\Repositories\Mosque\ProfileRepository;
use Illuminate\Support\ServiceProvider;

class InterfaceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(AuthInterface::class, AuthRepository::class);
        $this->app->bind(ProfileInterface::class, ProfileRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
