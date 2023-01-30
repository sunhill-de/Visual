<?php

namespace Sunhill\Visual\Managers;

use Sunhill\Visual\Modules\SunhillModuleBase;
use Sunhill\Visual\Modules\SunhillAction;

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
    
    /**
     * Returns the current active Module defined by the actual path
     * @return \Sunhill\Visual\Modules\SunhillModuleBase|\Sunhill\Visual\Modules\unknown|NULL|NULL
     */
    public function getCurrentEndpoint()
    {
        return $this->getActiveModule(request()->path());
    }

    protected function getPathOf($module)
    {
        if (is_null($module)) {
            return '';
        }
        return $module->getLink();
    }
    
    public function getCurrentEndpointPath()
    {
        return $this->getPathOf($this->getCurrentEndpoint());
    }
    
    /**
     * Returns the current feature. That means if the current module is a action, it returns it parent otherwise
     * the current module. 
     * @return unknown|NULL
     */
    public function getCurrentFeature()
    {
        if (($active_module = $this->getCurrentEndpoint())) {
            if (is_a($active_module,SunhillAction::class)) {
                return $active_module->getParent();
            } else {
                return $active_module;
            }
        }
        return null;
    }
    
    public function getCurrentFeaturePath()
    {
        return $this->getPathOf($this->getCurrentFeature());    
    }
    
    /**
     * returns the current submodule
     * @return unknown|NULL
     */
    public function getCurrentSubModule()
    {
        if (($active_feature = $this->getCurrentFeature())) {
            return $active_feature->getParent();
        }
        return null;
    }
    
    public function getCurrentSubModulePath()
    {
        return $this->getPathOf($this->getCurrentSubModule());    
    }
    
    public function getCurrentMainModule()
    {
        $path_parts = explode('/',request()->path());
        $module_name = array_shift($path_parts);
        return $this->getActiveModule($module_name);        
    }

    public function getCurrentMainModulePath()
    {
        return $this->getPathOf($this->getCurrentMainModule());    
    }
    
}
