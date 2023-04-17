<?php

namespace Sunhill\Visual\Response;

use Sunhill\Visual\Facades\Dialogs;

trait AccessData
{
   
    protected function getArrayData($data, $item)
    {
        if (isset($data[$item])) {
            return $data[$item];
        }
        if (is_string($item) && (strpos($item,'=>'))) {
            list($object,$key) = explode('=>',$item);
            if (isset($data[$object])) {
                return $this->accessData($data[$object],$key);
            }
        }
        return null;
    }
    
    protected function getObjectData($data, $item)
    {
        try {
            if (is_string($item) && (strpos($item,'=>'))) {
                list($object,$key) = explode('=>',$item);
                $object = $data->$object;
                if (isset($object)) {
                    return $this->accessData($object,$key);
                } else {
                    return '';
                }
            }
            return $data->$item;
        } catch (\Exception $e) {
        }
        return null;        
    }
    
    protected function accessData($data, $item = null)
    {
        switch ($item) {
            case 'keyfield':
                return Dialogs::getObjectKeyfield($data);
            case 'id':
                if (is_a($data, ORMObject::class)) {
                    return $data->getID();
                }
            case 'class':
                if (is_a($data, ORMObject::class)) {
                    return $data::getInfo('name');
                }
        }
        if (is_array($data)) {
            return $this->getArrayData($data, $item);
        }
        if (is_object($data)) {
            return $this->getObjectData($data, $item);
        }
        if (is_callable($item)) {
            return $item($data);
        }
    }
    
}