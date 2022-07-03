<?php

namespace Sunhill\Visual\Response\Database\Objects;

use Sunhill\Visual\Response\ListResponse;
use Sunhill\ORM\Facades\Objects;
use Sunhill\ORM\Utils\ObjectList;

class ListObjectsResponse extends ListResponse
{

    protected $columns = ['UUID'];
    
    protected $template = 'visual::objects.list';
    
    protected function prepareList($key=null)
    {
        return Objects::getObjectList($key);
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
