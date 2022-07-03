<?php

namespace Sunhill\Visual\Response\Database\Objects;

use Sunhill\Visual\Response\BladeResponse;
use Sunhill\ORM\Facades\Objects;
use Sunhill\ORM\Utils\ObjectList;
use Sunhill\ORM\Facades\Classes;

class AddObjectResponse extends BladeResponse
{

    protected $template = 'visual::objects.add';
    
    protected function prepareResponse()
    {
        $result = $this->solveRemaining('key=ORMObject');
        $this->params['key'] = $result['key'];
        $this->params['class'] = Classes::getNamespaceOfClass($result["key"]);
    }
}  
