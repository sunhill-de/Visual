<?php

namespace Sunhill\Visual\Modules;

class ModuleGroup extends ModuleBase
{
    
    protected $site_manager;
    
    public function setSiteManager(SiteManager $manager)
    {
        $this->site_manager = $manager;
        return $this;
    }
    
    public function getSiteManager(): String
    {
        return $this->site_manager;
    }
        
}
