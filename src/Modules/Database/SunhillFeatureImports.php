<?php

namespace Sunhill\Visual\Modules\Database;

use Sunhill\Visual\Response\Database\Classes\ListClassesResponse;

use Sunhill\Visual\Modules\SunhillModuleBase;

class SunhillFeatureImports extends SunhillModuleBase
{
    
    protected function setupModule()
    {
        $this->setName('Imports');
        $this->setDisplayName('Imports');        
        $this->setDescription('Imports');
        $this->addIndex(\Sunhill\Visual\Controllers\Database\ImportsController::class);
        $this->addAction('List')
            ->addControllerAction([\Sunhill\Visual\Controllers\Database\ImportsController::class, 'list'])
            ->setVisible(true)
            ->setRouteAddition('/{page?}');
        $this->addAction('Show')
            ->addControllerAction([\Sunhill\Visual\Controllers\Database\ImportsController::class, 'show'])
            ->setVisible(false)
            ->setRouteAddition('/{id}');
    }
    
    
}
