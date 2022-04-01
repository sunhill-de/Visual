<?php

namespace Sunhill\Visual\Modules;

class SiteManager extends ModuleBase
{
    protected function addModuleGroup(string $name, ModuleGroup $group)
    {
        $group->setSiteManager($this);
        $this->addSubEntity($name,$group);
        return $this;
    }
    
    protected function addModule(string $name, string $group, $module)
    {
    }
    
    protected function addFeature(string $name, string $group, $feature)
    {
    }
    
}
