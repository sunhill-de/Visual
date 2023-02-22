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
            ->setRouteAddition('/{key?}/{page?}')
            ->setAlias('objects.list');
        $this->addAction('Show')
            ->addControllerAction([\Sunhill\Visual\Controllers\Database\ObjectsController::class, 'show'])
            ->setVisible(false)
            ->setRouteAddition('/{id}')
            ->setAlias('objects.show');
        $this->addAction('Add')
            ->addControllerAction([\Sunhill\Visual\Controllers\Database\ObjectsController::class, 'add'])
            ->setVisible(true)
            ->setRouteAddition('/{class?}')
            ->setAlias('objects.add');
        $this->addAction('ExecAdd')
            ->setMethod('post')
            ->addControllerAction([\Sunhill\Visual\Controllers\Database\ObjectsController::class, 'execadd'])
            ->setVisible(false)
            ->setAlias('objects.execadd');
        $this->addAction('Edit')
            ->addControllerAction([\Sunhill\Visual\Controllers\Database\ObjectsController::class, 'edit'])
            ->setVisible(false)
            ->setRouteAddition('/{id}')
            ->setAlias('objects.edit');
        $this->addAction('ExecEdit')
            ->addControllerAction([\Sunhill\Visual\Controllers\Database\ObjectsController::class, 'execedit'])
            ->setVisible(false)
            ->setRouteAddition('/{id}')
            ->setAlias('objects.execedit');
        $this->addAction('Delete')
            ->addControllerAction([\Sunhill\Visual\Controllers\Database\ObjectsController::class, 'delete'])
            ->setVisible(false)
            ->setRouteAddition('/{id}')
            ->setAlias('objects.delete');
    }
    
    
}
