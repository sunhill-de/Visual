<?php

namespace Sunhill\Visual\Response\Crud;

use Sunhill\Visual\Response\SunhillResponseBase;
use Sunhill\Visual\Response\Lists\ListDescriptor;
use Sunhill\Visual\Response\SunhillUserException;

abstract class SunhillCrudResponse extends SunhillResponseBase
{
    
    /**
     * Defines how many entry per page should be displayed with lists
     */
    const ENTRIES_PER_PAGE = 12;
    
    /**
     * Defines how many paginator links should be left and right to the current entry
     */
    const PAGINATOR_NEIGHBOURS = 10;
    
    /**
     * Any derrived response has to fill in the route base here (e.g. users)
     * @var string
     */
    protected static $route_base = '';
    
    /**
     * A derrived response can fill up this array with methods for group actions. That are
     * actions that apply to multiple entries. If empty no group actions are provided
     * @var array
     */
    protected static $group_action = [];
    
    /**
     * If this variable is set to true the list response will provide a filter mechanism
     * @var boolean
     */
    protected static $has_filters = true;
    
    protected function exception(\Exception $e)
    {
        
    }
    
    /**
     * Every sunhill template uses a basic set of parameters. These are filled here. Can be overwritten
     * to add additional parameters
     * @return unknown
     */
    protected function getCommonParameters()
    {
        return array_merge($this->getBasicParams(),['crud_base'=>static::$route_base]);
    }
    
    protected function getRoutingParameters()
    {
        return [];    
    }
    
// *************************** Routines for list *********************************************
    protected $offset = 0;
    
    protected $order = 'id';
    
    protected $order_dir = 'asc';
    
    protected $filter = 'none';
    
    /**
     * This method has to be implemented by any derrived list to define what columns should be displayed
     * @param ListDescription $descriptor
     */
    abstract protected function defineList(ListDescriptor &$descriptor);
    
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
    
    /**
     * Returns the count of entries for the given filter (if any)
     * @param string $filter
     */
    abstract protected function getEntryCount(): int;
    
    /**
     * Return the table Data
     */
    abstract protected function getData();
  
    /**
     * When groupactions is set, an additional column is added with checkboxes and for each groupaction
     * a button is placed on the bottom of the table that triggers the wanted group action
     * @param unknown $result
     */
    protected function handleGroupActions(&$result)
    {
        $result['groupactions'] = [];
        
        foreach (static::$group_action as $action) {
            switch ($action) {
                case 'edit':
                    $result['groupactions'][] = $this->getStdClass(['action'=>$action,'title'=>_('edit'),'route'=>route(static::$route_base.'.groupedit')]);
                    break;
                case 'delete':
                    $result['groupactions'][] = $this->getStdClass(['action'=>$action,'title'=>_('delete'),'route'=>route(static::$route_base.'.confirmgroupdelete')]);
                    break;
                default:    
                    $result['groupactions'][] = $this->getStdClass(['action'=>$action,'title'=>_($action),'route'=>route(static::$route_base.'.'.$action)]);
                    break;
            }
        }        
    }
    
    protected function getSearchFields()
    {
        return [];    
    }
    
    protected function handleFilters(&$result)
    {
        if ($result['has_filter'] = static::$has_filters) {
            $result['filters'] = [];
            $result['searchfields'] = $this->getSearchFields();
        }
    }
    
    protected function getSingleListParameters()
    {
        $result = [];
        
        $this->handleGroupActions($result);
        $this->handleFilters($result);
        
        return $result; 
    }
    
    private function getPage(): int
    {
        return 0;    
    }
    
    private function getOrder(): string
    {
        return 'id';    
    }
    
    private function getOrderName($target = ''): string
    {
        if ($target == '') {
            return ($this->order_dir == 'desc')?'desc_'.$this->order:$this->order;
            
        } else {
            $direction = $this->order_dir;
            if ($this->order == $target) {
                $direction = ($this->order_dir == 'asc')?'desc':'asc';
            }
            return ($direction == 'desc')?'desc_'.$target:$target;            
        }
    }
    
    protected function getListHeader(ListDescriptor $descriptor)
    {
        $header = [];
        
        if (!empty(static::$group_action)) {
            $header[] = $this->createStdClass(['title'=>'','class'=>'is-narrow']);
        }
        foreach ($descriptor as $entry) {
            $header_entry = $entry->getHeaderEntry();
            if ($target = $entry->getColumnSortable()) {
                $parameters = $this->getRoutingParameters();
                $parameters['page']  = $this->getPage();
                $parameters['order'] = $this->getOrderName($target);
                $parameters['filter'] = $this->filter;
                $header_entry->title = '<a href="'.route(static::$route_base.'.list',$parameters).'">'.$header_entry->title.'</a>';
            }
            $header[] = $header_entry;
        }
        
        return ['headers'=>$header];        
    }
    
    protected function getListBody(ListDescriptor $descriptor)
    {
        return ['items'=>[]];
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
        $route_data = $this->getRoutingParameters();
        $route_data['page'] = $offset;
        $route_data['order'] = $this->getOrderName();
        $route_data['filter'] = $this->filter;
        /*        if (!empty($this->key)) {
         $route_data['key'] = $this->key;
         } */
        return route(static::$route_base.'.list',$route_data);
    }
    
    protected function getListPaginator(ListDescriptor $descriptor)
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
        
        return ['pages'=>$result,'current_page'=>$current_page];
    }
        
    protected function getListParams()
    {
        $result = [];
        
        $result = array_merge($result, $this->getCommonParameters());
        $result = array_merge($result, $this->getSingleListParameters());
        
        $list_descriptor = $this->getListDescriptor();
        $result = array_merge($result, $this->getListHeader($list_descriptor));
        $result = array_merge($result, $this->getListBody($list_descriptor));
        $result = array_merge($result, $this->getListPaginator($list_descriptor));
        return $result;    
    }

    private function handleDirection(string $order)
    {
        if (substr($order,0,5) == 'desc_') {
            $this->order = substr($order,5);
            $this->order_dir = 'desc';
        } else {
            $this->order = $order;
            $this->order_dir = 'asc';
        }        
    }
    
    /**
     * Lists the entries of the entity with the following parameters
     * @param int $page = What page to display (calculated by $page * ENTRIES_PER_PAGE)
     * @param string $order = In what order should the entries be displayed
     * @param array $filter = What filter(s) should be applied (if any)
     */
    public function list(int $page, string $order = 'id', string $filter = 'none')
    {
        $template = 'collection::'.static::$route_base.'.list';

        $this->offset = $page;
        $this->handleDirection($order);        
        $this->filter = $filter;
        
        try {
            $response = view($template, $this->getListParams());
        } catch (SunhillUserException $e) {
            return $this->exception($e);
        }
        return $response;
    }

// ****************************** Routines for filterList ***************************************
    public function filter(string $order = 'id')
    {
        $parameters = $this->getRoutingParameters();
        $parameters['page']  = 0;
        $parameters['order'] = $order;
        return redirect(route(static::$route_base.'.list',$parameters));
    }
    
    /**
     * Checks if the given id is valid. If yes return true, if not raise a 
     * @param unknown $id
     */
    protected function checkID($id)
    {
        
    }
    
    /**
     * Shows details of the entity with the given id
     * @param unknown $id = Normally an integer that identifies the entity
     */
    public function show($id)
    {
        
    }
    
    /**
     * Opens a dialog to add another entity
     */
    public function add()
    {
        
    }
    
    /**
     * Checks the entered values and adds the given entity
     * @param array $parameters
     */
    public function execAdd(array $parameters)
    {
        
    }
    
    /**
     * Opens a dialog to edit the given entity
     * @param unknown $id = Normally an integer that identies the entity
     */
    public function edit($id)
    {
        
    }
    
    /**
     * Checks the entered values and updates the given entity
     * @param unknown $id = Normally an integer that identies the entity
     * @param array $parameters
     */
    public function execEdit($id, array $parameters)
    {
        
    }
    
    /**
     * Deletes the given entity
     * @param unknown $id = Normally an integer that identies the entity
     */
    public function delete($id)
    {
        
    }
    
    /**
     * Opens a dialog to change the groupeditable fields of the given entities
     * @param array $ids an array of ids (normally integers) that identify the entities
     */
    public function groupEdit(array $ids)
    {
        
    }
    
    /**
     * Checks the entered values and changes them on the given entities
     * @param array $ids
     * @param array $parameters
     */
    public function execGroupEdit(array $ids, array $parameters)
    {
        
    }
    
    /**
     * Displays a summary of the entities to delete and asks for a confirmation
     * @param array $ids
     */
    public function confirmGroupDelete(array $ids)
    {
        
    }
    
    /**
     * Deletes the entities with the given ids
     * @param array $ids
     */
    public function executeGroupDelete(array $ids)
    {
        
    }
    
}