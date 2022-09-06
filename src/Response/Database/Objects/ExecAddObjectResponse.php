<?php

namespace Sunhill\Visual\Response\Database\Objects;

use Illuminate\Http\Request;

use Sunhill\Visual\Response\RedirectResponse;
use Sunhill\ORM\Facades\Classes;

class ExecAddObjectResponse extends ObjectResponseBase
{
    
    protected $target = '/';

    protected function getObject()
    {
        $classname = $this->request->input('_class');
        $this->target = $this->params['prefix'].'/Objects/list/'.$classname;
        
        return Classes::createObject($classname);       
    }
    
}  
    
