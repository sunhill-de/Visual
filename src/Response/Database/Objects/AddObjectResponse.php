<?php

namespace Sunhill\Visual\Response\Database\Objects;

use Sunhill\Visual\Response\BladeResponse;
use Sunhill\ORM\Facades\Objects;
use Sunhill\ORM\Utils\ObjectList;
use Sunhill\Visual\Traits\GetProperties;

class AddObjectResponse extends BladeResponse
{

    use GetProperties;
    
    protected $template = 'visual::objects.add';
    
    protected function prepareResponse()
    {
        $result = $this->solveRemaining('key=ORMObject');
        $classname = $result['key'];
        $classnamespace = $this->getNamespace($classname);
        $class = new \StdClass();
        $class->name = $classname;
        $class->namespace = $classnamespace;
        $class->fields = $this->getEditable($classnamespace);
        $class->tablename = $classnamespace::getInfo('table');
        $this->params['key'] = $result['key'];
        $this->params['class'] = $class;
    }
    
}  
