<?php

namespace Sunhill\Visual;

use Illuminate\Support\ServiceProvider;
use Sunhill\Visual\Managers\DialogManager;
use Sunhill\Visual\Managers\SiteManager;
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
        $this->app->singleton(SiteManager::class, function () { return new SiteManager(); } );
        $this->app->alias(SiteManager::class,'sitemanager');
    }
    
    public function boot()
    {
        $this->loadJSONTranslationsFrom(__DIR__.'/../resources/lang');
        $this->loadRoutesFrom(__DIR__.'/Routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views','visual');
    //    $this->loadViewComponentsAs('input', [Input::class]);
        Blade::component('visual-input', Input::class);
        Blade::component('visual-data', Data::class);
   //     InfoMarket::installMarketeer(Database::class);
        
    }

}
