<?php

namespace App\Providers;

use App\Models\Audio;
use App\Repositories\Audio\AudioRepository;

use App\Repositories\Audio\Elqouent\AudioRepositoryEloquent;
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

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
