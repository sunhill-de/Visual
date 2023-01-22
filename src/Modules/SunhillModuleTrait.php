<?php

namespace Sunhill\Visual\Modules;

use Sunhill\Visual\Facades\SunhillSiteManager;
use Illuminate\Http\Request;

trait SunhillModuleTrait
{
 
    protected function getBasicParams()
    {
        return [
            'breadcrumbs'=>SunhillSiteManager::getCurrentBreadcumbs(),
            'nav_1'=>SunhillSiteManager::getMainNavigation(),
            'sitename'=>SunhillSiteManager::getDisplayName()            
        ];
    }
    
}