<?php

namespace Sunhill\Visual\Response\Database\Objects;

use Illuminate\Http\Request;

use Sunhill\Visual\Response\RedirectResponse;
use Sunhill\ORM\Facades\Classes;
use Sunhill\ORM\Facades\Objects;

class ExecEditObjectResponse extends ObjectResponseBase
{
    
    protected $target = '/';

    protected function getWorkingObject()
    {
        $result = $this->solveRemaining('id');
        $object_id = $result['id'];
        $object = Objects::load($object_id);        
        
        $this->clearLists($object);
        $this->target = $this->params['prefix'].'/Objects/show/'.$object_id;
        
        return $object;       
    }
    
    protected function clearLists($object)
    {
        $fields = $this->getEditable($object);

        foreach ($fields as $field) {
          $name = $field->name;
          $property = $object->getProperty($name);  
          $fieldtype = $property->getType();
          if (($fieldtype == 'ArrayOfStrings') || ($fieldtype == 'ArrayOfObjects')) {
            $object->$name = [];
          }
          $object->tags = [];
//          $object->attributes = [];
        }  
    }  
}  
    
