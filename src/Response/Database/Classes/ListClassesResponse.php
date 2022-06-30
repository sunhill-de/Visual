<?php

namespace Sunhill\Visual\Response\Database\Classes;

use Sunhill\Visual\Response\ListResponse;
use Sunhill\ORM\Facades\Classes;

class ListClassesResponse extends ListResponse
{
    
    protected $template = 'visual::classes.list';
    
    protected function prepareList($key=null)
    {
        $all_classes = Classes::getAllClasses();
        $result = [];
        foreach ($all_classes as $name => $description)
        {
                $entry = new \StdClass();
                $entry->name = $description['name'];
                $entry->class = $description['class'];
                $entry->table = $description['table'];
                $entry->description = (isset($description['description'])?$description['description']:"");
                $entry->parent = $description['parent'];
                $result[] = $entry;
        }    
        return $result;
    }
    
}  
