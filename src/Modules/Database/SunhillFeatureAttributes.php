<?php

namespace Sunhill\Visual\Modules\Database;

use Sunhill\Visual\Response\Database\Classes\ListClassesResponse;

use Sunhill\Visual\Modules\SunhillModuleBase;

class SunhillFeatureAttributes extends SunhillModuleBase
{
    
    protected function setupModule()
    {
        $this->setName('Attributes');
        $this->setDisplayName('Attributes');        
        $this->setDescription('Attributes');
        $this->addIndex(\Sunhill\Visual\Controllers\Database\AttributesController::class);
        $this->addAction('List')
            ->addControllerAction([\Sunhill\Visual\Controllers\Database\AttributesController::class, 'list'])
            ->setVisible(true)
            ->setRouteAddition('/{page?}');
        $this->addAction('Show')
            ->addControllerAction([\Sunhill\Visual\Controllers\Database\AttributesController::class, 'show'])
            ->setVisible(false)
            ->setRouteAddition('/{id}');
    }
    
    
}
