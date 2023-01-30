<?php

namespace Sunhill\Visual\Response\Database\Objects;

use Sunhill\Visual\Response\SunhillBladeResponse;
use Sunhill\ORM\Facades\Objects;
use Sunhill\ORM\Utils\ObjectList;
use Sunhill\Visual\Traits\GetProperties;

class EditObjectResponse extends SunhillBladeResponse
{

    use GetProperties;
    
    protected $template = 'visual::objects.edit';
    
    protected $id;
    
    protected function prepareResponse()
    {
        parent::prepareResponse();
        $object_id = $this->id;
        $object = Objects::load($object_id);        
        $classnamespace = $this->getNamespace($object);
        
        $fields = $object->getProperties()->where('editable',true)->get();
        $this->params['fields'] = $fields;
        $this->params['classname'] = $object::getInfo('name');
        $this->params['object'] = $object;
    }
    
    public function setID($id)
    {
        $this->id = $id;
        return $this;
    }
}  
