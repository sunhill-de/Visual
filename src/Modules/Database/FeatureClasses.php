<?php

namespace Sunhill\Visual\Modules\Database;

use Sunhill\Visual\Response\Database\ListClassesResponse;

use Sunhill\Visual\Modules\ModuleBase;

class FeatureClasses extends ModuleBase
{
    
    protected function setupModule()
    {
        $this->setName('Classes');        
        $this->setDescription(__('Classes')); 
        $this->addSubEntry('list', ListClassesResponse::class,__('add class'));
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
