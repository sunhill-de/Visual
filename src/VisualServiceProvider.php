<?php

namespace Sunhill\Visual;

use Illuminate\Support\ServiceProvider;
use Sunhill\Visual\Managers\DialogManager;
use Sunhill\Visual\Components\Input;
use Illuminate\Support\Facades\Blade;

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
    //    $this->loadViewComponentsAs('input', [Input::class]);
        Blade::component('visual-input', Input::class);
        
        
    }

}
