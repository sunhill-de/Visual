<?php

namespace Sunhill\Visual\Response\Database\Classes;

use Sunhill\Visual\Response\ListResponse;
use Sunhill\ORM\Facades\Classes;

class ListClassesResponse extends ListResponse
{
    
    protected $template = 'visual::classes.list';
    
    protected function prepareHeaders(): array 
    {
        $this->params['headers'] = [
            $this->createStdClass(['name'=>__('Class name'),'link'=>null]),
            $this->createStdClass(['name'=>__('Name'),'link'=>null]),
            $this->createStdClass(['name'=>__('Description'),'link'=>null]),
            $this->createStdClass(['name'=>__('Parent'),'link'=>null]),
            $this->createStdClass(['name'=>"",'link'=>null]),
            $this->createStdClass(['name'=>"",'link'=>null]),
            $this->createStdClass(['name'=>"",'link'=>null]),
        ];
        return $this->params['headers'];
    }
    
    protected function prepareList($key,$order,$delta,$limit)
    {
        return $this->sliceList(Classes::getAllClasses(),$delta);
    }

    protected function prepareMatrix($input): array
    {
        $result = [];        
        foreach ($input as $name => $description)
        {
            $row = [];
            $row[] = $this->createStdClass(['name'=>$description['class'],'link'=>null]);
            $row[] = $this->createStdClass(['name'=>$description['name'],'link'=>null]);
            $row[] = $this->createStdClass(['name'=>(isset($description['description'])?$description['description']:""),'link'=>null]);
            $row[] = $this->createStdClass(['name'=>$description['parent'],'link'=>null]);
            $row[] = $this->createStdClass(['name'=>__('list'),'link'=>$this->params['prefix'].'/Objects/list/'.$description['name']]);
            $row[] = $this->createStdClass(['name'=>__('add'),'link'=>$this->params['prefix'].'/Objects/add/'.$description['name']]);
            $row[] = $this->createStdClass(['name'=>__('show'),'link'=>$this->params['prefix'].'/Objects/show/'.$description['name']]);
            $result[] = $row;
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
    
}  
