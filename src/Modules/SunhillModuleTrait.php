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
            'nav_3'=>SunhillSiteManager::get3rdLevelNavigation(),
            'sitename'=>SunhillSiteManager::getDisplayName(),
            'currentEndpointPath'=>SunhillSiteManager::getCurrentEndpointPath(),
            'currentFeaturePath'=>SunhillSiteManager::getCurrentFeaturePath(),
            'currentSubModulePath'=>SunhillSiteManager::getCurrentSubModulePath(),
            'currentMainModulePath'=>SunhillSiteManager::getCurrentMainModulePath(),
        ];
    }
    
}
