<?php

namespace Sunhill\Visual;

use Illuminate\Support\ServiceProvider;
use Sunhill\Visual\Managers\DialogManager;

class VisualServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(DialogManager::class, function () { return new DialogManager(); } );
        $this->app->alias(DialogManager::class,'dialogmanager');
    }
    
    public function boot()
    {
        $this->loadJSONTranslationsFrom(__DIR__.'/../resources/lang');
        $this->loadRoutesFrom(__DIR__.'/Routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views','visual');
    }

}
