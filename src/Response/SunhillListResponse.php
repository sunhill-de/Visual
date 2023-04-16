<?php

/**
 * @file SunhillListResponse
 * Basic class that return blade templates
 *
 */
namespace Sunhill\Visual\Response;

use Sunhill\Visual\Modules\SunhillModuleTrait;

/**
 * Baseclass list responses
 * @author klaus
 *
 * Every link has the following format:
 * /List/key?/offset/order?/filter?/filter_condition
 * Meaning:
 * key: a key is a kind of filter that tells the list, which entries should be displayer (Example: Class of objects). 
 *      This parameter is oprional
 * offset: The offset means which page of the list should be displayed. If omitted defaults to 0
 * order: The order parameter tells the list, in what order the entries should be displayed. This parameter is optional
 * filter: The filter parameter is a identifier that is resolved to a specialized filter (optional)
 * filter_condition: Optional parameter that describes the filter (optional)
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
    
    /**
     * The key of this list (see above)
     * @var string
     */
    protected $key = '';
    
    /**
     * The offset (page) of this list (see above)
     * @var integer
     */
    protected $offset = 0;
    
    /**
     * The ordering of the list (see above)
     * @var string
     */
    protected $order = 'id';

    /**
     * The current set filter of this list (see above)
     * @var string
     */
    protected $filter = '';
    
    /**
     * The current filter condition of this list (see above)
     * @var string
     */
    protected $filter_condition = '';
    
    public function setKey(string $key): SunhillListResponse
    {
        $this->key = $key;
        return $this;
    }
    
    public function setOffset(int $offset): SunhillListResponse
    {
        $this->offset = $offset;
        return $this;
    }
    
    public function setOrder(string $order): SunhillListResponse
    {
        $this->order = $order;
        return $this;
    }
    
    public function setFilter(string $filter): SunhillListResponse
    {
        $this->filter = $filter;
        return $this;
    }
    
    public function setFilterCondition(string $filter_condition): SunhillListResponse
    {
        $this->filter_condition = $filter_condition;
        return $this;
    }
    
    /**
     * This method has to be implemented by any derrived list to define what columns should be displayed
     * @param ListDescription $descriptor
     */
    abstract protected function defineList(ListDescriptor &$descriptor);
    
    /**
     * Returns the count of entries for the given filter (if any)
     * @param string $filter
     */
    abstract protected function getEntryCount(string $filter = '');
    
    /**
     * Creates a list descriptor and calls defineLIst()
     * @return \Sunhill\Visual\Response\ListDescriptor
     */
    protected function getListDescriptor()
    {
        $list_descriptor = new ListDescriptor();
        $this->defineList($list_descriptor);
        return $list_descriptor;
    }
    
    protected function prepareResponse()
    {
        parent::prepareResponse();
        
        $list_descriptor = $this->getListDescriptor();
        
    }
    
}