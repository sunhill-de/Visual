<?php

namespace Sunhill\Visual\Modules\Database;

use Sunhill\Visual\Response\Database\ListObjectsResponse;
use Sunhill\Visual\Response\Database\AddObjectResponse;
use Sunhill\Visual\Response\Database\ExecAddObjectResponse;
use Sunhill\Visual\Response\Database\EditObjectResponse;
use Sunhill\Visual\Response\Database\ExecEditObjectResponse;
use Sunhill\Visual\Response\Database\GroupEditObjectResponse;
use Sunhill\Visual\Response\Database\ExecGroupEditObjectResponse;
use Sunhill\Visual\Response\Database\DeleteObjectResponse;
use Sunhill\Visual\Response\Database\ShowObjectResponse;

use Sunhill\Visual\Modules\ModuleBase;

class FeatureObjects extends ModuleBase
{
    
    protected function setupModule()
    {
        $this->setName('Objects');        
        $this->setDescription(__('Objects')); 
        $this->addSubEntry('list', ListObjectsResponse::class,__("list objects"));
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
