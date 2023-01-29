<?php

namespace Sunhill\Visual\Modules\Database;

use Sunhill\Visual\Response\Database\Classes\ListClassesResponse;

use Sunhill\Visual\Modules\SunhillModuleBase;

class SunhillFeatureObjects extends SunhillModuleBase
{
    
    protected function setupModule()
    {
        $this->setName('Objects');
        $this->setDisplayName('Objects');        
        $this->setDescription('Objects');
        $this->addIndex(\Sunhill\Visual\Controllers\Database\ObjectsController::class);
        $this->addAction('List')
            ->addControllerAction([\Sunhill\Visual\Controllers\Database\ObjectsController::class, 'list'])
            ->setVisible(true)
            ->setRouteAddition('/{key?}/{page?}');
        $this->addAction('Show')
            ->addControllerAction([\Sunhill\Visual\Controllers\Database\ObjectsController::class, 'show'])
            ->setVisible(false)
            ->setRouteAddition('/{id}');
        $this->addAction('Add')
            ->addControllerAction([\Sunhill\Visual\Controllers\Database\ObjectsController::class, 'add'])
            ->setVisible(true)
            ->setRouteAddition('/{class?}');
        $this->addAction('ExecAdd')
            ->setMethod('post')
            ->addControllerAction([\Sunhill\Visual\Controllers\Database\ObjectsController::class, 'execadd'])
            ->setVisible(false)
            ->setRouteAddition('/{class}');
        $this->addAction('Edit')
            ->addControllerAction([\Sunhill\Visual\Controllers\Database\ObjectsController::class, 'edit'])
            ->setVisible(false)
            ->setRouteAddition('/{id}');
        $this->addAction('ExecEdit')
            ->addControllerAction([\Sunhill\Visual\Controllers\Database\ObjectsController::class, 'execedit'])
            ->setVisible(false)
            ->setRouteAddition('/{id}');
        $this->addAction('Delete')
            ->addControllerAction([\Sunhill\Visual\Controllers\Database\ObjectsController::class, 'delete'])
            ->setVisible(false)
            ->setRouteAddition('/{id}');
    }
    
    
}
