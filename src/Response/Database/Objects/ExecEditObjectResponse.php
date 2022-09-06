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
          $object->attributes = [];
        }  
    }  
}  
    
