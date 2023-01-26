<?php

namespace Sunhill\Visual\Modules\Database;

use Sunhill\Visual\Response\Database\Classes\ListClassesResponse;

use Sunhill\Visual\Modules\SunhillModuleBase;

class SunhillFeatureClasses extends SunhillModuleBase
{
    
    protected function setupModule()
    {
        $this->setName('Classes');
        $this->setDisplayName('Classes');        
        $this->setDescription('Classes');
        $this->addIndex(\Sunhill\Visual\Controllers\Database\ClassesController::class);
        $this->addAction('List')
            ->addControllerAction([\Sunhill\Visual\Controllers\Database\ClassesController::class, 'list'])
            ->setVisible(true)
            ->setRouteAddition('/{page?}');
        $this->addAction('Show')
            ->addControllerAction([\Sunhill\Visual\Controllers\Database\ClassesController::class, 'show'])
            ->setVisible(false)
            ->setRouteAddition('/{class}');
    }
    
    
}
