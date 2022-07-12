<?php

namespace Sunhill\Sunhill\Response\Computer\Database;

use Sunhill\ORM\Facades\Classes;
use Sunhill\ORM\Facades\Objects;
use Sunhill\ORM\Utils\ObjectList;

class AddObjectResponse extends ObjectsResponse
{
        
    protected function prepareResponse()
    {
        $passed = $this->solveRemaining('class');
        
        
        $parts = explode("/",$this->remaining);
        $class = $parts[0];
        
        $this->template = $this->getBestTemplate($class,'add');
        $this->params['fields'] = $this->getFields($class);
        $this->params['class'] = $class;
    }
    
}