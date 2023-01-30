<?php

namespace Sunhill\Visual\Response\Database\Classes;

use Sunhill\Visual\Response\SunhillListResponse;
use Sunhill\ORM\Facades\Classes;
use Sunhill\Visual\Facades\SunhillSiteManager;

class ListClassesResponse extends SunhillListResponse
{
    
    protected $template = 'visual::classes.list';
    
    protected function prepareHeaders(): array 
    {
        $this->params['headers'] = [
            $this->getStdClass(['name'=>__('Class name'),'link'=>null]),
            $this->getStdClass(['name'=>__('Name'),'link'=>null]),
            $this->getStdClass(['name'=>__('Description'),'link'=>null]),
            $this->getStdClass(['name'=>__('Parent'),'link'=>null]),
            $this->getStdClass(['name'=>"",'link'=>null]),
            $this->getStdClass(['name'=>"",'link'=>null]),
            $this->getStdClass(['name'=>"",'link'=>null]),
        ];
        return $this->params['headers'];
    }
    
    protected function prepareList($key,$order,$delta,$limit)
    {
        return $this->sliceList(Classes::getAllClasses(),$delta);
    }

    protected function getPrefix()
    {
        return SunhillSiteManager::getPrefix();    
    }
    
    protected function prepareMatrix($input): array
    {
        $result = [];        
        foreach ($input as $name => $description)
        {
            if ($description['name'] == 'object') {
                $description['name'] = 'ORMObject'; // @todo: Dirty hack to remove error in list objects
            }
            $row = [];
            $row[] = $this->getStdClass(['name'=>$description['class'],'link'=>null]);
            $row[] = $this->getStdClass(['name'=>$description['name'],'link'=>null]);
            $row[] = $this->getStdClass(['name'=>(isset($description['description'])?$description['description']:""),'link'=>null]);
            $row[] = $this->getStdClass(['name'=>$description['parent'],'link'=>null]);
            $row[] = $this->getStdClass(['name'=>__('list'),'link'=>SunhillSiteManager::getCurrentSubmodulePath().'/Objects/List/'.$description['name']]);
            $row[] = $this->getStdClass(['name'=>__('add'),'link'=>SunhillSiteManager::getCurrentSubmodulePath().'/Objects/Add/'.$description['name']]);
            $row[] = $this->getStdClass(['name'=>__('show'),'link'=>SunhillSiteManager::getCurrentFeaturePath().'/Show/'.$description['name']]);
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
        return SunhillSiteManager::getCurrentFeaturePath().'/List/'.$index;
    }
    
}  
