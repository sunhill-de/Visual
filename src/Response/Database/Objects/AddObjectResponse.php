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
        $classname = $result['key'];
        $classnamespace = Classes::getNamespaceOfClass($classname);
        $class = new \StdClass();
        $class->name = $classname;
        $class->namespace = $classnamespace;
        $class->fields = $this->getFields($classnamespace);
        $class->tablename = $classnamespace::$object_infos['table'];
        $this->params['key'] = $result['key'];
        $this->params['class'] = $class;
    }
    
    protected function getFields($namespace)
    {
        $fields = $namespace::staticGetProperties()->where('editable',true)->get();
        $result = [];
        foreach ($fields as $field) {
            $item = new \StdClass();
            $item->name = $field->getName();
            $result[] = $item;
        }
        return $result;
    }
}  
