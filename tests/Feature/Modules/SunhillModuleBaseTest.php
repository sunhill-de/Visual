<?php

namespace Sunhill\Visual\Tests\Feature;

use Sunhill\Visual\Modules\SunhillModuleBase;
use Sunhill\Basic\Tests\SunhillNoAppTestCase;

class SunhillModuleBaseTest extends SunhillNoAppTestCase
{
    
    protected function getCurrentDisplayName(string $display_name, string $name)
    {
        if (empty($display_name)) {
            return $name;
        }
        return __($display_name);
    }
    
    public function addIndex($controller, string $action="index")
    {
        $this->addAction('index')->addControllerAction([$controller, $action]);
    }
    
    public function addAction(string $name,
        string $display_name = "",
        string $description = "",
        bool $visible = false)
    {
        $action = new SunhillAction();
        $action->setName($name)
        ->setDisplayName($this->getCurrentDisplayName($display_name,$name))
        ->setVisible($visible)
        ->setDescription($description);
        $this->addSubmoduleEntry($action);
        return $action;
    }
    
    public function installRoutes()
    {
        foreach ($this->submodules as $submodule) {
            $submodule->installRoutes();
        }
    }
    
    
}