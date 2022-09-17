<?php

namespace Sunhill\Visual\Modules\Database;


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
        $this->addSubEntry('list', ListTagsResponse::class,__("list tags"))
            ->setVisible()
            ->setName('list')
            ->setDisplayName(__('List tags'));
        $this->addSubEntry('add', AddTagResponse::class)
            ->setVisible()
            ->setName('add')
            ->setDisplayName(__('Add tag'));
        $this->addSubEntry('execadd', ExecAddTagResponse::class)
            ->setName('execadd');
        $this->addSubEntry('edit', EditTagResponse::class)->setName(__('Edit tag'))
            ->setName('edit');
        $this->addSubEntry('execedit', ExecEditTagResponse::class)
            ->setName('execedit');
     //   $this->addSubEntry('delete', DeleteTagResponse::class);
        $this->addSubEntry('show', ShowTagResponse::class)->setName(__('Show tag'))
            ->setName('show'); 
    }
    
    
}
