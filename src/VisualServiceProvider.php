<?php

namespace Sunhill\Visual;

use Illuminate\Support\ServiceProvider;

class VisualServiceProvider extends ServiceProvider
{
    public function register()
    {
    }
    
    public function boot()
    {
        $this->loadJSONTranslationsFrom(__DIR__.'/../resources/lang');
        
        $this->app->singleton(ModuleManager::class, function () { return new ModuleManager(); } );
        $this->app->alias(ModuleManager::class,'modules');
    }

}
