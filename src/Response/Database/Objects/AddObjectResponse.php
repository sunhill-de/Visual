<?php

namespace Sunhill\Visual\Response\Database\Objects;

use Sunhill\Visual\Response\SunhillBladeResponse;
use Sunhill\ORM\Facades\Objects;
use Sunhill\ORM\Utils\ObjectList;
use Sunhill\Visual\Traits\GetProperties;

class AddObjectResponse extends SunhillBladeResponse
{

    use GetProperties;
    
    protected $template = 'visual::objects.add';
    
    protected $class = '';
    
    protected function prepareResponse()
    {
        parent::prepareResponse();
        $classnamespace = $this->getNamespace($this->class);
        if (!$classnamespace::getInfo('instantiable')) {
            throw new \Exception('Tried to instantiate object of uninstantiable class: '.$this->class);
        }
        $class = new \StdClass();
        $class->name = $this->class;
        $class->namespace = $classnamespace;
        $class->fields = $this->getEditable($classnamespace);
        $class->tablename = $classnamespace::$object_infos['table'];
        $this->params['key'] = $this->class;
        $this->params['class'] = $class;
    }
    
    public function setClass(string $class)
    {
        $this->class = $class;
        return $this;
    }
}  
