<?php

namespace Sunhill\Visual\Response\Database\Classes;

use Sunhill\Visual\Response\BladeResponse;
use Sunhill\ORM\Facades\Classes;

class ListClassesResponse extends BladeResponse
{
    
    protected $template = 'visual::classes.list';
    
    private function sliceClassesList($classlist,$delta)
    {
        $result = [];
        $i = 0;
        foreach ($classlist as $key => $description)
        {
            if ($i>($delta+1)*ENTRIES_PER_PAGE) {
                return $result;
            }
            if ($i>=$delta*ENTRIES_PER_PAGE) {
                $entry = new \StdClass();
                $entry->name = $description['name'];
                $entry->class = $description['class'];
                $entry->table = $description['table'];
                $entry->description = (isset($description['description'])?$description['description']:"");
                $entry->parent = $description['parent'];
                $result[] = $entry;
            }
            $i++;
        }
        
        return $result;
    }

    protected function getClassList(int $page, string $oder)
    {
        $all_classes = Classes::getAllClasses();
        $classes = $this->sliceClassesList($all_classes,$page,ENTRIES_PER_PAGE);

        $pages = [];
        if (count($all_classes) > ENTRIES_PER_PAGE) {
            $count = ceil(count($all_classes) / ENTRIES_PER_PAGE);
            for ($i=0;$i<$count;$i++) {
                $pages[$i] = $i*ENTRIES_PER_PAGE;
            }
        }
        return $classes;
    }
    
    protected function prepareResponse()
    {
        $passed = $this->solveRemaining('delta=0/order=name');        
        $this->params['delta'] = $passed['delta'];
        $this->params['order'] = $passed['order'];
        $this->params['classes'] = $this->getClassList($passed['delta'],$passed['order']);        
    }
    
}  
