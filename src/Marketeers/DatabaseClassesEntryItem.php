<?php

namespace Sunhill\Visual\Marketeers;

use Sunhill\InfoMarket\Market\ObjectLeaf;
use Sunhill\ORM\Facades\Classes;

class DatabaseClassesEntryItem extends ObjectLeaf
{
    
    protected $name;
    
    protected $table;
    
    protected $parent;
    
    public function __construct($id)
    {
        $this->name = Classes::getClassName($id);
        $this->table = Classes::getTableOfClass($this->name);
        $this->parent = Classes::getParentOfClass($this->name);
    }
        
    protected function getAllowedFields()
    {
        return ['name','table','parent'];
    }
    
    protected function getObjectValue(string $name, array $remaining)
    {
        return $this->$name;
    }
    
    protected function getObjectMetadata(string $next, array $remaining)
    {
        $result = ['type'=>'Str','update'=>'late', 'unit'=>'None','readable'=>true,'writeable'=>false];
        switch ($next) {
            case 'name':
                $result['semantic'] = 'Name';
                break;
        }
        return $result;
    }
}
