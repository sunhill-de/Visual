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
        
        
/*        $this->addSubEntry('add', AddObjectResponse::class);
        $this->addSubEntry('execadd', ExecAddObjectResponse::class);
        $this->addSubEntry('edit', EditObjectResponse::class);
        $this->addSubEntry('execedit', ExecEditObjectResponse::class);
        $this->addSubEntry('groupedit', GroupEditObjectResponse::class);
        $this->addSubEntry('execgroupedit', ExecGroupEditObjectResponse::class);
        $this->addSubEntry('delete', DeleteObjectResponse::class);
        $this->addSubEntry('show', ShowObjectResponse::class); */
    }
    
    
}
