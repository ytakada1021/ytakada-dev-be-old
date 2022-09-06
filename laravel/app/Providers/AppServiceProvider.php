<?php

namespace App\Providers;

use App\Command\Models\Common\Implementations\CommonMarkConverter;
use App\Command\Models\Common\MarkdownConverter;
use App\Command\Models\Post\Implementations\DoctrinePostRepository;
use App\Command\Models\Post\PostRepository;
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
        $this->app->singleton(PostRepository::class, DoctrinePostRepository::class);
        $this->app->singleton(MarkdownConverter::class, CommonMarkConverter::class);
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
