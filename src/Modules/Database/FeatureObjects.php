<?php

namespace Sunhill\Visual\Modules\Database;

use Sunhill\Visual\Response\Database\Objects\ListObjectsResponse;
use Sunhill\Visual\Response\Database\Objects\ShowObjectResponse;
use Sunhill\Visual\Response\Database\Objects\AddObjectResponse;
use Sunhill\Visual\Response\Database\Objects\ExecAddObjectResponse;
use Sunhill\Visual\Response\Database\Objects\EditObjectResponse;
use Sunhill\Visual\Modules\ModuleBase;
use Sunhill\Visual\Facades\Dialogs;

class FeatureObjects extends ModuleBase
{
    
    protected function setupModule()
    {
        $this->setName('Objects');        
        $this->setDescription(__('Objects')); 
        $this->addSubEntry('list', 'listObjects',__("list objects"));
        $this->addSubEntry('add', 'addObject',__("add object"));
        $this->addSubEntry('execadd', ExecAddObjectResponse::class,"");
        $this->addSubEntry('edit', EditObjectResponse::class);
/**        $this->addSubEntry('execedit', ExecEditObjectResponse::class);
        $this->addSubEntry('groupedit', GroupEditObjectResponse::class);
        $this->addSubEntry('execgroupedit', ExecGroupEditObjectResponse::class);
        $this->addSubEntry('delete', DeleteObjectResponse::class); */
        $this->addSubEntry('show', ShowObjectResponse::class, __("Show object")); 
    }
    
    protected function listObjects($remaining,$request,$params)
    {
        $parts = explode('/',$remaining);
        $params['columns'] = Dialogs::getObjectListFields($parts[0]);
        $responseClass = Dialogs::getObjectResponse('list',$parts[0]);
        $response = new $responseClass();
        $response->setRemaining($remaining);
        $response->setRequest($request);
        $response->setParams($params);
        return $response->response();
    }
    
    protected function addObject($remaining,$request,$params)
    {
        $parts = explode('/',$remaining);
        $responseClass = Dialogs::getObjectResponse('add',$parts[0]);
        $response = new $responseClass();
        $response->setRemaining($remaining);
        $response->setRequest($request);
        $response->setParams($params);
        return $response->response();        
    }
    
}
