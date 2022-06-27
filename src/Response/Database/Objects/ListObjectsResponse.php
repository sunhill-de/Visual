<?php

namespace Sunhill\Visual\Response\Database\Objects;

use Sunhill\Visual\Response\ListResponse;
use Sunhill\ORM\Facades\Objects;
use Sunhill\ORM\Utils\ObjectList;

define("ENTRIES_PER_PAGE", 25);

class ListObjectsResponse extends ListResponse
{

    protected $columns = ['UUID'];
    
    protected $template = 'visual::objects.list';
    
    protected function prepareList($key=null)
    {
        return Objects::getObjectList($class);
    }
    
    private function sliceObjectList($objectlist,$delta)
    {
        $result = new ObjectList();
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
        $this->params['columns'] = $this->getColumns();
        $this->params['inheritance'] = array_reverse($this->getFixedInheritance($params['key']));
    }
    
    protected function getColumns()
    {
        return ['UID'];     
    }
}  
