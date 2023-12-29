<?php

namespace App\Providers;

use App\Models\Audio;
use App\Models\User;
use App\Repositories\Audio\AudioRepository;
use App\Repositories\User\UserRepository;
use App\Repositories\Audio\Elqouent\AudioRepositoryEloquent;
use App\Repositories\User\Elqouent\UserRepositoryEloquent;
use Illuminate\Support\ServiceProvider;

class AppRepositoryProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AudioRepository::class, function(){
            return new AudioRepositoryEloquent(new Audio);
        });

        $this->app->bind(UserRepository::class, function(){
            return new UserRepositoryEloquent(new User);
        });

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
