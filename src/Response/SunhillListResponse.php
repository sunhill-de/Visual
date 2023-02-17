<?php

/**
 * @file SunhillBlaseResponse
 * Basic class that return blade templates
 *
 */
namespace Sunhill\Visual\Response;

use Sunhill\Visual\Modules\SunhillModuleTrait;

/**
 * Baseclass list responses
 * @author klaus
 *
 */
abstract class SunhillListResponse extends SunhillBladeResponse
{
    
    /**
     * Defines how many entry per page should be displayed
     */
    const ENTRIES_PER_PAGE = 12;
    
    /**
     * Defines how many paginator links should be left and right to the current entry
     */
    const PAGINATOR_NEIGHBOURS = 10;
    
    protected $key = 'id';
    
    protected $delta = 0;
    
    protected $order = 'id';
    
    public function setKey(string $key)
    {
        $this->key = $key;
        return $this;
    }
    
    public function setDelta(int $delta)
    {
        $this->delta = $delta;
        return $this;
    }
    
    public function setOrder(string $order)
    {
        $this->order = $order;
        return $this;
    }
    
    /**
     * Returns a list of all entries of the given item
     * @param $key if given the key is a sub amount of entries
     * @returns array the unsorted, unliced list of all entries
     */
    abstract protected function prepareList($key,$order,$delta,$limit);
    
    abstract protected function prepareMatrix($input): array;
    
    abstract protected function prepareHeaders(): array;
    
    /**
     * Slices the given list
     */
    protected function sliceList($list,int $page): array
    {
        $result = [];
        $start = $page*self::ENTRIES_PER_PAGE;
        $end = ($page+1)*self::ENTRIES_PER_PAGE-1;
        $i=0;
        foreach ($list as $key => $entry) {
            if (($i >= $start) && ($i <= $end)) {
                $result[$key] = $entry;
            }
            $i++;
        }
        return $result;
    }
    
    protected function getPaginator(array $list): array
    {
    }
    
    /**
     * The default param processing expects a delta field and a order field, key is defaulted to empty
     */
    function getParams(): array
    {
        return ['delta'=>$this->delta, 'order'=>$this->order, 'key'=>$this->key];
    }
    
    /**
     * Extracts the params and set defaults to those that needn't to be processed
     */
    private function processParams()
    {
        $params = $this->getParams();
        $this->params['key'] = $params['key'];
        $this->params['delta'] = $params['delta'];
        $this->params['order'] = $params['order'];
    }
    
    /**
     * Retrieves the list of items, sorts it and then slices it
     */
    private function processList()
    {
        $this->params['items'] = $this->prepareMatrix($this->prepareList($this->params['key'],$this->params['order'],$this->params['delta'],self::ENTRIES_PER_PAGE));
    }
    
    /**
     * Returns the total number of entries in this list
     * @return int
     */
    protected function getTotalEntryCount()
    {
    }
    
    protected function getPaginatorLink(int $index)
    {
    }
    
    protected function getCurrentPage()
    {
        return $this->params['delta'];
    }
    
    protected function processPaginator()
    {
        if (self::ENTRIES_PER_PAGE >= $this->getTotalEntryCount()) {
            $this->params['pages'] = [];
            return;
        }
        $pages = ceil($this->getTotalEntryCount() / self::ENTRIES_PER_PAGE); // Number of pages
        $current_page = $this->getCurrentPage();
        
        if (($current_page - self::PAGINATOR_NEIGHBOURS)<1) {
            $start = 1;
            $this->params['left_ellipse'] = '';
        } else {
            $start = ($current_page - self::PAGINATOR_NEIGHBORS);
            $this->params['left_ellipse'] = '...';
        }
        if (($current_page + self::PAGINATOR_NEIGHBOURS)>($pages-1)) {
            $end = $pages - 1;
            $this->params['right_ellipse'] = '';
        } else {
            $end = ($current_page + self::PAGINATOR_NEIGHBOURS);
            $this->params['right_ellipse'] = '...';
        }
        
        $result = [];
        $entry = new \StdClass();
        $entry->link = $this->getPaginatorLink(0);
        $entry->text = "1";
        $result[] = $entry;
        for ($i=$start;$i<$end;$i++) {
            $entry = new \StdClass();
            $entry->link = $this->getPaginatorLink($i);
            $entry->text = $i+1;
            $result[] = $entry;
        }
        $entry = new \StdClass();
        $entry->link = $this->getPaginatorLink($pages-1);
        $entry->text = $pages;
        $result[] = $entry;
        
        $this->params['pages'] = $result;
    }
    
    /**
     * This method could be overwritten to do some additional processing
     */
    protected function processAdditional()
    {
    }
    
    protected function processHeaders()
    {
        $this->params['headers'] = $this->prepareHeaders();
    }
    
    protected function prepareResponse()
    {
        parent::prepareResponse();
        $this->processParams();
        $this->processHeaders();
        $this->processList();
        
        $this->processPaginator();
        $this->processAdditional();
    }
        
}