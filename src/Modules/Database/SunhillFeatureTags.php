<?php

namespace Sunhill\Visual\Modules\Database;

use Sunhill\Visual\Response\Database\Classes\ListClassesResponse;

use Sunhill\Visual\Modules\SunhillModuleBase;

class SunhillFeatureTags extends SunhillModuleBase
{
    
    protected function setupModule()
    {
        $this->setName('Tags');
        $this->setDisplayName('Tags');        
        $this->setDescription('Tags');
        $this->addIndex(\Sunhill\Visual\Controllers\Database\TagsController::class);
        $this->addAction('List')
            ->addControllerAction([\Sunhill\Visual\Controllers\Database\TagsController::class, 'list'])
            ->setVisible(true)
            ->setRouteAddition('/{page?}')
            ->setAlias('tags.list');
        $this->addAction('Show')
            ->addControllerAction([\Sunhill\Visual\Controllers\Database\TagsController::class, 'show'])
            ->setVisible(false)
            ->setRouteAddition('/{id}')
            ->setAlias('tags.show');
    }
    
    
}
