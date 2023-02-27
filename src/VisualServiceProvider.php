<?php

namespace Sunhill\Visual;

use Illuminate\Support\ServiceProvider;
use Sunhill\Visual\Managers\DialogManager;
use Sunhill\Visual\Managers\SunhillSiteManager;
use Sunhill\Visual\Facades\Dialogs;

use Sunhill\Visual\Components\Input;
use Sunhill\Visual\Components\Data;
use Illuminate\Support\Facades\Blade;
use Sunhill\InfoMarket\Facades\InfoMarket;
use Sunhill\Visual\Marketeers\Database;

class VisualServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(DialogManager::class, function () { return new DialogManager(); } );
        $this->app->alias(DialogManager::class,'dialogmanager');
        $this->app->singleton(SunhillSiteManager::class, function () { return new SunhillSiteManager(); } );
        $this->app->alias(SunhillSiteManager::class,'sunhillsitemanager');
    }
    
    public function boot()
    {
        $this->loadJSONTranslationsFrom(__DIR__.'/../resources/lang');
        $this->loadRoutesFrom(__DIR__.'/Routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views','visual');
    //    $this->loadViewComponentsAs('input', [Input::class]);
        Blade::component('visual-data', Data::class);
        
        Dialogs::addCSSResource(__DIR__.'/../resources/css');
        Dialogs::addJSResource(__DIR__.'/../resources/js');
    }

}
