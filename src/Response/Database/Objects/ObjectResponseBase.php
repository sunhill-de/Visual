<?php

namespace Sunhill\Visual\Response\Database\Objects;

use Illuminate\Http\Request;

use Sunhill\Visual\Response\RedirectResponse;
use Sunhill\ORM\Facades\Objects;
use Sunhill\ORM\Facades\Classes;
use Sunhill\ORM\Utils\ObjectList;
use Sunhill\Visual\Traits\GetProperties;

/**
 * A baseclass for adding oder modifying objects
 */
abstract class ObjectResponseBase extends RedirectResponse
{

    use GetProperties;
    
    abstract protected function getObject();    
      
    protected function prepareResponse()
    {    
        $object = $this->getObject();
        $fields = $this->getEditable($object);

        foreach ($fields as $field) {
          $property = $object->getProperty($field->name);  
          $fieldname = $property->getName();
          $fieldtype = $property->getType();
          $handler = 'get'.$fieldtype;
          if (!method_exists($this,'get'.$fieldtype)) {
              throw new \Exception(__("No handler for ':fieldtype'",['fieldtype'=>$fieldtype]));
          }
          $value = $this->$handler($this->request->input($fieldname,null),$property);
          
          if (is_array($value)) {
              foreach ($value as $single) {
                  $object->$fieldname[] = $single;
              }
          } else {
              if (!is_null($value)) {
                $object->$fieldname = $value;
              }
          }
        }
        if ($this->request->has('tagcount')) {
            $this->getTags($object);
        }
        if ($this->request->has('attributecount')) {
            $this->getAttributes($object);   
        }
        $object->commit();
    }

    protected function getVarchar($value,$field)
    {
        return substr($value,0,$field->getMaxLen());           
    }
    
    protected function getInteger($value,$field)
    {
        if (empty($value)) {
            return null;
        }
        if (!is_numeric($value)) {
            throw new \Exception(__("':value' is not an integer",['value'=>$value]));            
        }
        return $value;
    }
    
    protected function getFloat($value,$field)
    {
        if (empty($value)) {
            return null;
        }
        if (!is_float($value)) {
            throw new \Exception(__("':value' is not an float",['value'=>$value]));
        }
        return $value;
    }
    
    protected function getText($value,$field)
    {
        return $value;        
    }
    
    protected function getEnum($value,$field)
    {
        if (empty($value)) {
            return null;
        }
        $allowed = $field->getEnumValues();
        if (!in_array($value,$allowed)) {
            throw new \Exception(__("':value' is not an allowed value",['value'=>$value]));
        }
        return $value;
    }

    private function isAllowed($value,$list)
    {
        foreach ($list as $entry) {
            if (Classes::isA($value,$entry)) {
                return true;
            }
        }
        return false;
    }

    protected function isAllowedObject($test, $allowed_objects)
    {
        if (is_numeric($test)) {
            $test = Objects::getClassNameOf(intval($test));
        }
        foreach ($allowed_objects as $object) {
            if (Classes::isA($test,$object)) {
                return true;
            }
        }
        return false;
    }
    
    protected function getObject($value,$field)
    {
        $value = $this->request->input($field->getName());
        if (empty($value)) {
            return null;
        }
        if (!is_numeric($value)) {
            throw new \Exception(__("':value' is not an object-id",['value'=>$value]));
        }
        if (is_numeric($value)) {
            $value = Objects::load(intval($value));
        }
        if (empty($value)) {
            throw new \Exception(__("':value' is not a valid object id",['value'=>$value]));
        }    
        if (!$this->isAllowedObject($value,$field->getAllowedObjects())) {
            throw new \Exception(__("':value' is not an allowed object for this field",['value'=>$value]));
        }
        return $value;
    }
    

    protected function getArrayOfStrings($value,$field)
    {
        $result = [];
        $name = $field->getName();
        $count = $this->request->input("count_".$name,0);
        for ($i=1;$i<=$count;$i++) {
            if ($this->request->has("_".$name.$i)) {
                $result[] = $this->request->input("value_".$name.$i);                
            }
        }
        return $result;
    }
    
    protected function getArrayOfObjects($value,$field)
    {
        $result = [];
        $name = $field->getName();
        $count = $this->request->input("count_".$name,0);
        for ($i=1;$i<=$count;$i++) {
            if ($this->request->has("value_".$name.$i)) {
                $id = $this->request->input("value_".$name.$i);
                $obj = Objects::load(intval($id));
                if (empty($obj)) {
                    throw new \Exception(__("':value' is not a valid object id",['value'=>$obj]));
                }    
                if (!$this->isAllowedObject($obj,$field->getAllowedObjects())) {
                    throw new \Exception(__("':value' is not an allowed object for this field",['value'=>$value]));
                }
                $result[] = $obj;
            }            
        }
        
        return $result;
    }
    
    /**
     * @todo Implement value checks
     * @param unknown $value
     * @param unknown $field
     * @return unknown
     */
    protected function getDate($value,$field)
    {
        if (empty($value)) {
            return null;
        }
        return $value;        
    }
    
    /**
     * @todo Implement value checks
     * @param unknown $value
     * @param unknown $field
     * @return unknown
     */
    protected function getTime($value,$field)
    {
        if (empty($value)) {
            return null;
        }
        return $value;
        
    }
    
    /**
     * @todo Implement value checks
     * @param unknown $value
     * @param unknown $field
     * @return unknown
     */
    protected function getDateTime($value,$field)
    {
        if (empty($value)) {
            return null;
        }
        return $value;       
    }
    
    protected function getTags($object)
    {
        for ($i=0;$i<$this->request->input('tagcount');$i++) {
            $tag = $this->request->input('tag'.$i);
            $object->tags->stick($tag);                 
        }
    }
    
    protected function getAttributes($object)
    {
        for ($i=0;$i<$this->request->input('attributecount');$i++) {
            $attribute_name = $this->request->input('attribute_name'.$i);
            $attribute_value = $this->request->input('attribute_value'.$i);
            $object->$attribute_name = $attribute_value;
        }        
    }
}  
    
