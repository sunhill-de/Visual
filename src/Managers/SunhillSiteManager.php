<?php

namespace Sunhill\Visual\Managers;

use Sunhill\Visual\Modules\SunhillModuleBase;

class SunhillSiteManager extends SunhillModuleBase
{
     
    public function getCurrentBreadcumbs()
    {
        if ($active_module = $this->getActiveModule(request()->path())) {
            return $active_module->getBreadcrumbs();   
        }            
        return [];
    }
    
    public function getMainNavigation()
    {
        return [];
    }
}
