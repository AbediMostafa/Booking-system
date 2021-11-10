<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::morphMap([
            'city'=>'App\Models\City',
            'room'=>'App\Models\Room',
            'genre'=>'App\Models\Genre',
            'post'=>'App\Models\Post',
            'movie'=>'App\Models\Movie',
            'news'=>'App\Models\News',
            'collection'=>'App\Models\Collection',
            'specific-media'=>'App\Models\SpecificMedia',
            'site-variable'=>'App\Models\SiteVariables',
        ]);
    }
}
