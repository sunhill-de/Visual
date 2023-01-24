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
         if ($submodule = $this->getActiveSubmodule(request()->path())) {
               return $submodule->getNavigationLinks();
         }     
         return [];
    }
    
    public function get3rdLevelNavigation()
    {
          if ($module = $this->getActiveSubmodule(request()->path())) {
               if ($submodule = $module->
          }     
    }
     
}
