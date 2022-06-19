<?php

namespace Sunhill\Visual\Response\Database;

use Sunhill\Visual\Response\BladeResponse;
use Sunhill\ORM\Facades\Objects;
use Sunhill\ORM\Utils\ObjectList;

define("ENTRIES_PER_PAGE", 25);

class ListObjectsResponse extends BladeResponse
{

    protected $columns = ['UUID'];
    
    protected $template = 'visual::objects.list';
    
    private function sliceObjectList($objectlist,$delta)
    {
        $result = new ObjectList();
        $i = 0;
        while (($i + $delta * ENTRIES_PER_PAGE < count($objectlist)) && ($i < ENTRIES_PER_PAGE)) {
            $result->add($objectlist[($i++)+$delta*ENTRIES_PER_PAGE]);
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
    
    protected function getObjectList(string $class, int $page, string $oder)
    {
        $all_objects = Objects::getObjectList($class);
        $objects = $this->sliceObjectList($all_objects,$page,ENTRIES_PER_PAGE);
        $pass_objects = [];
        foreach ($objects as $object) {
            if ($object && ($object->id > 0)) {
                $pass_objects[] = $object;
            }
        }
        $pages = [];
        if (count($all_objects) > ENTRIES_PER_PAGE) {
            $count = ceil(count($all_objects) / ENTRIES_PER_PAGE);
            for ($i=0;$i<$count;$i++) {
                $pages[$i] = $i*ENTRIES_PER_PAGE;
            }
        }
        return $pass_objects;
    }
    
    protected function prepareResponse()
    {
        $passed = $this->solveRemaining('class=ORMObject/delta=0/order=id');        
        $this->params['class'] = $passed['class'];
        $this->params['delta'] = $passed['delta'];
        $this->params['order'] = $passed['order'];
        $this->params['inheritance'] = array_reverse($this->getFixedInheritance($passed['class']));
        
        $this->params['columns'] = $this->getColumns();
        $this->params['objects'] = $this->getObjectList($passed['class'],$passed['delta'],$passed['order']);
        
    }
    
    protected function getColumns()
    {
        return ['UID'];     
    }
}  
