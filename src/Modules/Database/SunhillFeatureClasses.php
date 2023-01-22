<?php

namespace Sunhill\Visual\Modules\Database;

use Sunhill\Visual\Response\Database\Classes\ListClassesResponse;

use Sunhill\Visual\Modules\SunhillModuleBase;

class SunhillFeatureClasses extends SunhillModuleBase
{
    
    protected function setupModule()
    {
        $this->setName('Classes');        
        $this->setDescription('Classes');
        $this->addIndex();
        
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
