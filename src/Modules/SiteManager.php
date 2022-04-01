<?php

namespace Sunhill\Visual\Modules;

class SiteManager extends ModuleBase
{
    protected $tree = [];
    
    /**
     * Searches the tree for a module group with the given name
     * It return a ModuleGroup object if found otherwise false
     * @param $name string The name of the module group to search
     */
    protected function findModuleGroup(string $name)
    {
        if (isset($this->tree[$name])) {
            return $this->tree[$name];
        } else {
            return false;
        }
    }
    
    protected function addModuleGroup(string $name, $group)
    {
        if ($this->findModuleGroup($name)) {
            throw new \Exception("The module group '$name' does already exist.");
        } else {
            $group->setSiteManager($this);
            $this->tree[$name] = $group;           
        }    
    }
    
    protected function addModule(string $name, string $group, $module)
    {
    }
    
    protected function addFeature(string $name, string $group, $feature)
    {
    }
    
}
