<?php

namespace Sunhill\Visual\Response\Database\Objects;

use Sunhill\Visual\Response\BladeResponse;
use Sunhill\ORM\Facades\Objects;
use Sunhill\ORM\Utils\ObjectList;
use Sunhill\Visual\Traits\GetProperties;

class EditObjectResponse extends BladeResponse
{

    use GetProperties;
    
    protected $template = 'visual::objects.edit';
    
    protected function prepareResponse()
    {
        $result = $this->solveRemaining('id');
        $object_id = $result['id'];
        $object = Objects::load($object_id);        
        $classnamespace = $this->getNamespace($object);
        
        $fields = $object->getProperties()->where('editable',true)->get();
        $this->params['fields'] = $fields;
        $this->params['classname'] = $object::$object_infos['name'];
        $this->params['object'] = $object;
    }
    
}  
