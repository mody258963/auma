<?php

namespace App\Providers;
//Category
use App\Models\Audio;
use App\Models\User;
use App\Models\Category;
use App\Models\Course;
use App\Repositories\Audio\AudioRepository;
use App\Repositories\User\UserRepository;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Course\CourseRepository;
use App\Repositories\Audio\Elqouent\AudioRepositoryEloquent;
use App\Repositories\User\Elqouent\UserRepositoryEloquent;
use App\Repositories\Category\Elqouent\CategoryRepositoryEloquent;
use App\Repositories\Course\Elqouent\CourseRepositoryEloquent;
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

        $this->app->bind(CategoryRepository::class, function(){
            return new CategoryRepositoryEloquent(new Category);
        });
        $this->app->bind(CourseRepository::class, function(){
            return new CourseRepositoryEloquent(new Course);
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
