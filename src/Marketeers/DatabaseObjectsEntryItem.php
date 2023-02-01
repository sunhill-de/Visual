<?php

namespace Sunhill\Visual\Marketeers;

use Sunhill\InfoMarket\Market\ObjectLeaf;
use Sunhill\ORM\Facades\Objects;

class DatabaseObjectsEntryItem extends ObjectLeaf
{
    
    protected $object;
    
    public function __construct($id)
    {
        $this->object = Objects::load($id);
    }
        
    protected function getAllowedFields()
    {
        return ['id'];
    }
    
    protected function getObjectValue(string $name, array $remaining)
    {
        switch ($name)
        {
            case 'id':
               return $this->object->getID();
            default:
               return $this->object->$name;
        }
    }
    
    protected function getObjectMetadata(string $next, array $remaining)
    {
        $result = ['update'=>'late', 'unit'=>'None','readable'=>true,'writeable'=>false];
        switch ($next) {
            case 'name':
                $result['semantic'] = 'Name';
                $result['type'] = 'Int';
                break;
        }
        return $result;
    }
}
