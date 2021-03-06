<?php
/**
 * @file ListResponse
 * Defines the abstract class ListResponse
 */
namespace Sunhill\Visual\Response;

/**
 * Defines how many entry per page should be displayed
 */
define("ENTRIES_PER_PAGE", 25);

/**
 * Abstract response that represent a List of something
 * provides the necessary methods to enable sorting, slicing, etc. 
 */
abstract class ListResponse extends BladeResponse
{
    
    protected $key = 'id';
    
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
        $i = 0;
        while (($i + $page * ENTRIES_PER_PAGE < count($list)) && ($i < ENTRIES_PER_PAGE)) {
            $result[] = $list[($i++)+$page*ENTRIES_PER_PAGE];  
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
       $result = $this->solveRemaining('delta=0/order=id');
       $result['key'] = '';
       return $result;
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
        $this->params['items'] = $this->prepareMatrix($this->prepareList($this->params['key'],$this->params['order'],$this->params['delta'],ENTRIES_PER_PAGE));
    }
  
    protected function processPaginator()
    {
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
        $this->processParams();
        $this->processHeaders();
        $this->processList();
        
        $this->processPaginator();
        $this->processAdditional();
    }
  
}  
