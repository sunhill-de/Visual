<?php

namespace Sunhill\Visual\Response\Database\Tags;

use Sunhill\Visual\Response\BladeResponse;
use Sunhill\ORM\Facades\Tags;
use Sunhill\Visual\Response\ListResponse;

class ListTagsResponse extends ListResponse
{

    protected $columns = ['name','parent'];
    
    protected $template = 'visual::tags.list';
    
    protected function prepareList($key,$order,$delta,$limit)
    {
        $tags = Tags::getAllTags($delta*$limit,$limit); 
        return $tags;
    }
    
    protected function getTotalEntryCount()
    {
        return Tags::getCount();
    }
    
    protected function getTagLink($key, $order = 'id', $delta = 0)
    {
        return $this->params['prefix']."/Tags/list/$key/$delta/$order";    
    }
    
    protected function createEntry($name,$link=null)
    {
        $result = new \StdClass();
        $result->name = $name;
        $result->link = $link;
        return $result;
    }
    
    protected function prepareHeaders(): array
    {
        $result = [
            $this->createEntry(__('id'),  $this->getTagLink($this->params['key'],$this->params['order'],$this->params['delta'])),
            $this->createEntry(__('name'),$this->getTagLink($this->params['key'],'name',$this->params['delta'])),
            $this->createEntry(__('parent'),$this->getTagLink($this->params['key'],'parent',$this->params['delta'])),
            $this->createEntry(__('fullpath'),$this->getTagLink($this->params['key'],'full_path',$this->params['delta'])),
            $result[] = $this->createEntry(" "),
            $result[] = $this->createEntry(" ")
        ];    
        return $result;
    }
    
    protected function prepareMatrix($input): array
    {
        $result = [];
        foreach ($input as $tag) {
            $row = [];
            $row[] = $this->createEntry($tag->getID(),$this->params['prefix'].'/Tags/show/'.$tag->getID());
            $row[] = $this->createEntry($tag->getName());
            $parent = $tag->getParent();
            if (is_null($parent)) {
                $row[] = $this->createEntry('&nsbp;');
            } else {
                $row[] = $this->createEntry($parent->getFullpath());
            }    
            $row[] = $this->createEntry($tag->getFullpath());
            $row[] = $this->createEntry(__("edit"),$this->params['prefix'].'/Tags/edit/'.$tag->getID());
            $row[] = $this->createEntry(__("delete"),$this->params['prefix'].'/Tags/delete/'.$tag->getID());
            $result[] = $row;
        }
        return $result;
    }
    
    function getParams(): array
    { 
       $result = $this->solveRemaining('key=ORMObject/delta=0/order=id');        
       return $result;
    }
  
}
