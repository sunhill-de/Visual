<?php

namespace Sunhill\Visual\Modules\Database;

use Sunhill\Visual\Response\Database\Import\ImportPersonsResponse;

use Sunhill\Visual\Modules\ModuleBase;

class FeatureImport extends ModuleBase
{
    
    protected function setupModule()
    {
        $this->setName('Import');        
        $this->setDescription(__('Import')); 
        $this->addSubEntry('persons', ImportPersonsResponse::class,__('persons'))
            ->setName('persons')
            ->setDisplayName('import persons')
            ->setVisible();
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
