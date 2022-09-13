<?php

namespace Sunhill\Visual\Response\Database\Classes;

use Sunhill\Visual\Response\ListResponse;
use Sunhill\ORM\Facades\Classes;

class ListClassesResponse extends ListResponse
{
    
    protected $template = 'visual::classes.list';
    
    protected function prepareList($key,$order,$delta,$limit)
    {
        return $this->sliceList(Classes::getAllClasses(),$delta);
    }

    protected function prepareMatrix($input): array
    {
        $result = [];
        foreach ($input as $name => $description)
        {
            $entry = new \StdClass();
            $entry->name = $description['name'];
            $entry->classname = $description['class'];
            $entry->table = $description['table'];
            $entry->description = (isset($description['description'])?$description['description']:"");
            $entry->parent = $description['parent'];
            $result[] = $entry;
        }
        return $result;        
    }
    
    protected function getTotalEntryCount()
    {
        return Classes::getClassCount();
    }
    
    
    protected function getPaginatorLink(int $index)
    {
        return $this->params['prefix'].'/Classes/list/'.$index;
    }
    
    protected function prepareHeaders(): array
    {
        return [];   
    }
    
}  
