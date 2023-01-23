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
            'nav_2'=>SunhillSiteManager::getSubNavigation(),
            'sitename'=>SunhillSiteManager::getDisplayName()            
        ];
    }
    
}