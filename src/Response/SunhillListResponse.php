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
 
    use AccessData;
    
    /**
     * Defines how many entry per page should be displayed
     */
    const ENTRIES_PER_PAGE = 12;
    
    /**
     * Defines how many paginator links should be left and right to the current entry
     */
    const PAGINATOR_NEIGHBOURS = 10;
    
    protected $route = '';
    
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
    abstract protected function getEntryCount(): int;
    
    abstract protected function getData();
    
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
    
    protected function getSortLink(ListEntry $entry)
    {
        if ($entry->getSearchable()) {
            return route($this->route,['page'=>0,'order'=>$entry->getName()]);
        } 
        return null;
    }
    
    protected function processHeader(ListDescriptor $descriptor)
    {
        $header = [];
        
        foreach ($descriptor as $entry) {
            $list_entry = new \StdClass();
            $list_entry->name = $entry->getTitle();
            $list_entry->link = $this->getSortLink($entry);
            
            $header[] = $list_entry;
        }
        
        $this->params['headers'] = $header;
    }

    protected function sliceData(array $data, int $offset = null): array
    {
        $offset = is_null($offset)?$this->offset:$offset;
        return array_slice($data, $offset * self::ENTRIES_PER_PAGE, self::ENTRIES_PER_PAGE);    
    }
        
    protected function getDataRow($data_row, ListDescriptor $descriptor)
    {
        $result = [];
        
        foreach ($descriptor as $entry) {
            $data_entry = new \StdClass();
            if (!is_null($data_item = $this->accessData($data_row, $entry->getName()))) {
                $data_entry->name = $data_item;
            } else {
                $data_entry->name = __($entry->getName());
            }
            $data_entry->link = $entry->getLink($data_row);
            
            $result[] = $data_entry;
        }
        
        return $result;
    }
    
    protected function processBody(ListDescriptor $descriptor)
    {
        $table_data = [];
        $data = $this->getData();
        foreach ($data as $data_row) {
            $table_data[] = $this->getDataRow($data_row, $descriptor);
        }
        $this->params['items'] = $table_data;
    }
    
    protected function getCurrentPage()
    {
        return $this->offset;
    }
    
    /**
     * Checks if there are less entries than in the ENTRIES_PER_PAGE constant. If yes
     * Clear the paginator and return true otherwise return false
     * @return bool
     */
    protected function checkForLessEntriesThanEntriesPerPage(): bool
    {
        if (self::ENTRIES_PER_PAGE < $this->getEntryCount()) {
            return false;
        }
        $this->params['pages'] = [];
        return true;
    }
    
    protected function getNumberOfPages(): int
    {
        return ceil($this->getEntryCount() / self::ENTRIES_PER_PAGE); // Number of pages
    }
    
    /**
     * Checks if the given index $page_index is below 0 or higher than number_of_pages. If yes
     * it raises an UserException
     * @param int $page_index
     * @param int $number_of_pages
     * @throws SunhillUserException
     */
    protected function checkWrongPageIndex(int $page_index, int $number_of_pages)
    {
        if (!$page_index) {
            return;
        }
        if (($page_index < 0) || ($page_index >= $number_of_pages)) {
            throw new SunhillUserException(__("The index ':index' is out of range.",['index'=>$page_index]));
        }
    }
    
    protected function getPaginatorLink(int $offset)
    {
        $route_data = ['page'=>$offset,'order'=>$this->order];
        if (!empty($this->key)) {
            $route_data['key'] = $this->key;
        }
        return route($this->route,$route_data);
    }
    
    protected function processPaginator(ListDescriptor $descriptor)
    {
        $pages = $this->getNumberOfPages();
        $current_page = $this->getCurrentPage();
        $this->checkWrongPageIndex($current_page, $pages);
        if ($this->checkForLessEntriesThanEntriesPerPage()) {
            return;
        }
        
        if (($current_page - self::PAGINATOR_NEIGHBOURS)<1) {
            $start = 1;
            $this->params['left_ellipse'] = '';
        } else {
            $start = ($current_page - self::PAGINATOR_NEIGHBOURS);
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
    
    protected function addStdFields()
    {
        $this->params['key'] = $this->key;    
        $this->params['order'] = $this->order;
        $this->params['filter'] = $this->filter;
        $this->params['page'] = $this->offset;
    }
    
    protected function prepareResponse()
    {
        parent::prepareResponse();
        
        $this->addStdFields();
        $list_descriptor = $this->getListDescriptor();
        $this->processHeader($list_descriptor);
        $this->processBody($list_descriptor);
        $this->processPaginator($list_descriptor);
    }
    
}