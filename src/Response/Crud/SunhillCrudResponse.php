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
                $parameters['order'] = $target;
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
    
    protected function getListPaginator(ListDescriptor $descriptor)
    {
        return [];
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
    
    /**
     * Lists the entries of the entity with the following parameters
     * @param int $page = What page to display (calculated by $page * ENTRIES_PER_PAGE)
     * @param string $order = In what order should the entries be displayed
     * @param array $filter = What filter(s) should be applied (if any)
     */
    public function list(int $page, string $order = 'id', string $order_dir = 'asc', array $filter = [])
    {
        $template = 'collection::'.static::$route_base.'.list';

        try {
            $response = view($template, $this->getListParams());
        } catch (SunhillUserException $e) {
            return $this->exception($e);
        }
        return view($template, $this->getListParams());
    }

// ****************************** Routines for filterList ***************************************
    public function filterList()
    {
        
    }
    
// **************************** Routines for execFilterList *************************************
    public function execFilterList()
    {
        
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