<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            \App\Repositories\Profile\ProfileRepositoryInterface::class,
            \App\Repositories\Profile\ProfileRepository::class
        );
        $this->app->singleton(
            \App\Repositories\Post\PostRepositoryInterface::class,
            \App\Repositories\Post\PostRepository::class
        );
        $this->app->singleton(
            \App\Repositories\Like\LikeRepositoryInterface::class,
            \App\Repositories\Like\LikeRepository::class
        );
        $this->app->singleton(
            \App\Repositories\Follow\FollowRepositoryInterface::class,
            \App\Repositories\Follow\FollowRepository::class
        );
        $this->app->singleton(
            \App\Repositories\Role\RoleRepositoryInterface::class,
            \App\Repositories\Role\RoleRepository::class
        );
        $this->app->singleton(
            \App\Repositories\Comment\CommentRepositoryInterface::class,
            \App\Repositories\Comment\CommentRepository::class
        );
        $this->app->singleton(
            \App\Repositories\Activity\ActivityRepositoryInterface::class,
            \App\Repositories\Activity\ActivityRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
