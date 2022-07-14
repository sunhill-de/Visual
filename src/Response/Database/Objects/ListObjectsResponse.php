<?php

namespace Sunhill\Visual\Response\Database\Objects;

use Sunhill\Visual\Response\ListResponse;
use Sunhill\ORM\Facades\Objects;
use Sunhill\ORM\Facades\Classes;
use Sunhill\ORM\Utils\ObjectList;
use Sunhill\Visual\Facades\Dialogs;

class ListObjectsResponse extends ListResponse
{

    protected $columns = ['uuid'];
    
    protected $template = 'visual::objects.list';
    
    protected function prepareList($key,$order,$delta,$limit)
    {
       return Objects::getPartialObjectList($key,$order,$delta*$limit,$limit); 
    }
    
    protected function getLink($key, $order = 'id', $delta = 0)
    {
        return $this->params['prefix']."/Objects/list/$key/$delta/$order";    
    }
    
    protected function createEntry($name,$link=null)
    {
        $result = new \StdClass();
        $result->name = $name;
        $result->link = $link;
        return $result;
    }
    
    protected function prepareHeaders(): array
    {
        $result = [
            $this->createEntry(__('id'),$this->getLink($this->params['key'],$this->params['order'],$this->params['delta'])),
            $this->createEntry(__('class'))            
        ];    
        
        $columns = Dialogs::getObjectListFields($this->params['key']);
        foreach ($columns as $index => $column) {
            
            if (is_int($index)) {
                $result[] = $this->createEntry(__($column),$this->getLink($this->params['key'],$column,$this->params['delta']));
            } else {
                $result[] = $this->createEntry(__($index));                
            }
        }
        $result[] = $this->createEntry(" ");
        $result[] = $this->createEntry(" ");
        return $result;
    }
    
    protected function parseColumn($object,$column)
    {
        if (strpos($column,"=>")) {
            list($key,$subkey) = explode("=>",$column);
            $key_object = $object->$key;
            if (is_null($key_object)) {
                return null;            
            } else {
                return $key_object->$subkey;
            }
        } else if ($column == "keyfield") {
            return Dialogs::getObjectKeyfield($object);
        } else {
            return $object->$column;
        }
    }
    
    protected function prepareMatrix($input): array
    {
        $result = [];
        foreach ($input as $object) {
            $row = [];
            $row[] = $this->createEntry($object->getID(),$this->params['prefix'].'/Objects/show/'.$object->getID());
            $row[] = $this->createEntry($object::$object_infos['name'],$this->getLink($object::$object_infos['name']));            $columns = Dialogs::getObjectListFields($this->params['key']);
            foreach ($columns as $index => $column) {
                if (is_int($index)) {
                    $row[] = $this->createEntry($this->parseColumn($object,$column));
                } else {
                    $row[] = $this->createEntry($this->parseColumn($object,$column));                    
                }
            }
            $row[] = $this->createEntry(__("edit"),$this->params['prefix'].'/Objects/edit/'.$object->getID());
            $row[] = $this->createEntry(__("delete"),$this->params['prefix'].'/Objects/delete/'.$object->getID());
            $result[] = $row;
        }
        return $result;
    }
    
    protected function getFixedInheritance(string $class)
    {
        if ($class == 'object') {
            return ['object'];
        } else {
            return Classes::getInheritanceOfClass($class,true);
        }
    }
    
    function getParams(): array
    { 
       $result = $this->solveRemaining('key=ORMObject/delta=0/order=id');        
       return $result;
    }
  
    protected function processAdditional()
    {
        $this->params['inheritance'] = array_reverse($this->getFixedInheritance($this->params['key']));
    }
    
}  
