<?php

namespace Sunhill\Visual\Modules\Database;

use Sunhill\Visual\Response\Database\Tags\ListTagsResponse;

use Sunhill\Visual\Modules\ModuleBase;

class FeatureTags extends ModuleBase
{
    
    protected function setupModule()
    {
        $this->setName('Tags');        
        $this->setDescription(__('Tags')); 
        $this->addSubEntry('list', ListTagsResponse::class,__("list tags"));
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
