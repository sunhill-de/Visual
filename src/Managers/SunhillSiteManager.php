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
          return $this->getNavigationLinks();
    }
     
    public function getSubNavigation()
    {
         if ($submodule = $this->getModuleOfLevel(request()->path(),1)) {
               return $submodule->getNavigationLinks();
         }     
         return [];
    }
    
    public function get3rdLevelNavigation()
    {
          if ($module = $this->getModuleOfLevel(request()->path(),2)) {
               return $module->getNavigationLinks(true);
          }
         return [];
    }
    
    public function getPrefix()
    {
        return '/Computer/Database';
    }
}
