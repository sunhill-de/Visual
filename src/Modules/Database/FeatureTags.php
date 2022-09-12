<?php

namespace Sunhill\Visual\Modules\Database;

use Sunhill\Visual\Response\Database\Tags\ListTagsResponse;

use Sunhill\Visual\Modules\ModuleBase;

use Sunhill\Visual\Response\Database\Tags\ListTagsResponse;
use Sunhill\Visual\Response\Database\Tags\AddTagResponse;
use Sunhill\Visual\Response\Database\Tags\ExecAddTagResponse;
use Sunhill\Visual\Response\Database\Tags\EditTagResponse;
use Sunhill\Visual\Response\Database\Tags\ExecEditTagResponse;
use Sunhill\Visual\Response\Database\Tags\DeleteTagResponse;
use Sunhill\Visual\Response\Database\Tags\ShowTagResponse;

class FeatureTags extends ModuleBase
{
    
    protected function setupModule()
    {
        $this->setName('Tags');        
        $this->setDescription(__('Tags')); 
        $this->addSubEntry('list', ListTagsResponse::class,__("list tags"));
        $this->addSubEntry('add', AddTagResponse::class);
        $this->addSubEntry('execadd', ExecAddTagResponse::class);
        $this->addSubEntry('edit', EditTagResponse::class);
        $this->addSubEntry('execedit', ExecEditTagResponse::class);
        $this->addSubEntry('delete', DeleteTagResponse::class);
        $this->addSubEntry('show', ShowTagResponse::class); 
    }
    
    
}
