<?php

namespace Sunhill\Visual\Response\Crud;

use Sunhill\Visual\Response\SunhillResponseBase;
use Sunhill\Visual\Response\Crud\ListDescriptor;

use Sunhill\Visual\Response\Crud\Exceptions\InvalidIDException;
use Sunhill\Visual\Response\Crud\Exceptions\InvalidPageException;
use Sunhill\Visual\Response\Crud\Exceptions\InvalidOrderKeyException;
use Sunhill\Visual\Response\Crud\Exceptions\SunhillUserException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Sunhill\ORM\Facades\ObjectData;

abstract class SunhillSemiCrudResponse extends SunhillResponseBase
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
     * If this variable is set to true the list response will provide a filter mechanism
     * @var boolean
     */
    protected static $has_filters = true;
    
    protected static $route_prefix = '';
    
    /**
     * A derrived response can fill up this array with methods for group actions. That are
     * actions that apply to multiple entries. If empty no group actions are provided
     * Note: Has to be implemented in SemiCrudResponse, because list() uses it
     * @var array
     */
    protected static $group_action = [];
    
    protected function exception(\Exception $e)
    {
        report($e);
        $params = $this->getBasicParams();
        $params['e'] = $e;
        return response()->view('visual::basic.usererror',$params, 500);        
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
    
    protected function getRoutingParameters($params = null)
    {
        if (is_array($params)) {
            return $params;
        } else if (is_scalar($params)) {
            return ['id'=>$params];
        } else {
            return [];
        }
    }

    protected static $entity = '';
    
    
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
     * For Listentries and count this method returns the query on which the other operation will
     * be performed.
     */
    abstract protected function getBasicQuery();
    
    /**
     * Creates a list descriptor and calls defineLIst()
     * @return \Sunhill\Visual\Response\ListDescriptor
     */
    protected function getListDescriptor()
    {
        $list_descriptor = new ListDescriptor();
        $list_descriptor->setParentParameters($this->getRoutingParameters());
        $this->defineList($list_descriptor);
        return $list_descriptor;
    }
    
    protected function getAdditionalLinks()
    {
        return [];    
    }
    
    protected function handleConditions($query, array $conditions)
    {
        foreach ($conditions as $condition) {
            if ($condition->connection == '') {
                $connection = 'where';
            } else {
                $connection = $condition->connection.'Where';
            }
            $query = $query->$connection($condition->field,$condition->relation,$condition->condition);
        }
        return $query;
    }
    
    /**
     * Returns the count of entries for the given filter (if any)
     * @param string $filter
     */
    protected function getEntryCount(): int
    {
        $query = $this->getBasicQuery();
        $query = $this->handleConditions($query, $this->getFilterConditions());
        return $query->count();        
    }
    
    /**
     * Return the table Data
     */
    protected function getData()
    {
        $order = $this->order; 
        $order_dir = $this->order_dir;
        $offset = $this->offset*self::ENTRIES_PER_PAGE;
        $limit = self::ENTRIES_PER_PAGE;
        
        $query = $this->getBasicQuery();;
        $query = $this->handleConditions($query, $this->getFilterConditions());
        if ($offset) {
            $query->offset($offset);
        }
        if ($limit) {
            $query->limit($limit);
        }
        $query->orderBy($order, $order_dir);
        return $query->get();        
    }
  
    protected function getDefaultOrder(): string
    {
        return 'id';    
    }
    
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
                    $result['groupactions'][] = $this->getStdClass(['action'=>$action,'title'=>_('edit'),'route'=>route(static::$route_base.'.groupedit',$this->getRoutingParameters())]);
                    break;
                case 'delete':
                    $result['groupactions'][] = $this->getStdClass(['action'=>$action,'title'=>_('delete'),'route'=>route(static::$route_base.'.confirmgroupdelete',$this->getRoutingParameters())]);
                    break;
                default:    
                    $result['groupactions'][] = $this->getStdClass(['action'=>$action,'title'=>_($action),'route'=>route(static::$route_base.'.'.$action,$this->getRoutingParameters())]);
                    break;
            }
        }        
    }
    
    protected function getSearchFields()
    {
        return [];    
    }
    
    protected function getFilters()
    {
        $is_temp = ($this->filter == 'none')?false:true;
        $result = [];
        $query = DB::table('listfilters')->where('list',static::$entity)->whereNull('bestbefore')->get();
        foreach ($query as $filter) {
            if ($this->filter == $filter->name_id) {
                $selected = 'selected';
                $is_temp = false;
            } else {
                $selected = '';
            }
            $result[] = $this->getStdClass([
                'value'=>$filter->name_id,
                'name'=>$filter->name,
                'selected'=>$selected
            ]);    
        }
        if ($is_temp) {
            $result[] = $this->getStdClass([
                'value'=>$this->filter,
                'name'=>__('temporary filter'),
                'selected'=>'selected'
            ]);
        }
        return $result;
    }
    
    protected function getFilterConditions()
    {
        if ($this->filter == 'none') {
            return [];
        } else {
            $result = DB::table('listfilters')->join('listfilterconditions','listfilters.id','=','listfilterconditions.listfilter_id')->where('name_id',$this->filter)->get();
            return $result->toArray();
        }
    }
    
    protected function handleFilters(&$result)
    {
        if ($result['has_filter'] = static::$has_filters) {
            $result['filters'] = $this->getFilters();
            $result['searchfields'] = $this->getSearchFields();
            $result['filter_none'] = ($this->filter == 'none')?'selected':'';
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
            $header[] = $this->getStdClass(['title'=>'','class'=>'is-narrow']);
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
    
    protected function sliceData(array $data, int $offset = null): array
    {
        $offset = is_null($offset)?$this->offset:$offset;
        return array_slice($data, $offset * self::ENTRIES_PER_PAGE, self::ENTRIES_PER_PAGE);
    }
    
    protected function processText(string $input): string
    {
        return $input;
    }
    
    protected function getID($data_row)
    {
        if (is_array($data_row)) {
            return $data_row['id'];
        }
        return $data_row->id;
    }
    
    protected function getDataRow($data_row, ListDescriptor $descriptor)
    {
        $result = [];
        if (!empty(static::$group_action)) {
            $id = $this->getID($data_row);
            $result[] = '<input type="checkbox" name="selected[]" value="'.$id.'">';
        }
        foreach ($descriptor as $entry) {
            if ($data = $entry->getDataEntry($data_row)) {
                $result[] = $data;
            } else {
                $result[] = $entry->getDataByCallback($descriptor->getDataCallback(),$data_row);
            }
        }
        
        return $result;
    }
    
    protected function getListBody(ListDescriptor $descriptor)
    {
        $table_data = [];
        $data = $this->getData();
        foreach ($data as $data_row) {
            $table_data[] = $this->getDataRow($data_row, $descriptor);
        }
        return ['items'=>$table_data];
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
    protected function checkWrongPageIndex(int &$page_index, int $number_of_pages)
    {
        if (!$page_index) {
            return;
        }
        if ($page_index < 0) {
            $page_index = $number_of_pages + $page_index; // negativ index means pages from the end
        }
        if (($page_index < 0) || ($page_index >= $number_of_pages)) {
            throw new InvalidPageException(__("The index ':index' is out of range.",['index'=>$page_index]));
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
        if ($this->checkForLessEntriesThanEntriesPerPage()) {
            return [];
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
        
    protected function checkValidOrder(string $order, ListDescriptor $descriptor)
    {
        if (substr($order,0,5) == 'desc_') {
            $this->order = substr($order,5);
        }
        foreach ($descriptor as $entry) {
            if ($entry->getColumnSortable() == $order) {
                return true;
            }
        }
        throw new InvalidOrderKeyException(__("':order' is not an allowed order key.",['order'=>$order]));
    }
    
    protected function getListParams()
    {
        $result = ['prefix'=>$this->getRoutingParameters(),'caption'=>__('List :entity',['entity'=>__(static::$entity)])];
        
        $result = array_merge($result, $this->getCommonParameters());
        $result = array_merge($result, $this->getSingleListParameters());
        
        $list_descriptor = $this->getListDescriptor();
        $this->checkValidOrder($this->order, $list_descriptor);
        $this->checkWrongPageIndex($this->offset, $this->getNumberOfPages());
        $result = array_merge($result, $this->getListHeader($list_descriptor));
        $result = array_merge($result, $this->getListBody($list_descriptor));
        $result = array_merge($result, $this->getListPaginator($list_descriptor));
        $result = array_merge($result, ['links'=>$this->getAdditionalLinks()]);
        return $result;    
    }

    private function handleDirection(string $order)
    {
        if ($order == 'default') {
            $this->order = $this->getDefaultOrder();
            $this->order_dir = 'asc';            
        } else if (substr($order,0,5) == 'desc_') {
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
    public function list(int $page, string $order = 'default', string $filter = 'none')
    {
        $template = 'visual::crud.list';

        try {
            $this->offset = $page;
            $this->handleDirection($order);        
            $this->filter = $filter;
        
            $response = view($template, $this->getListParams());
        } catch (SunhillUserException $e) {
            return $this->exception($e);
        }
        return $response;
    }

// ****************************** Routines for filterList ***************************************
    protected function handleFilterDialog()
    {
        $request = request();
        $name_id = ObjectData::getUniqueID();
        if ($request->post('save')) {
            $name = $request->post('save');
            $bestbefore = null;
        } else {
            $name = '';
            $bestbefore = date('Y-m-d H:i:s', strtotime('2 hours'));            
        }
        DB::table('listfilters')->insert(
            [
                'bestbefore'=>$bestbefore,
                'name'=>$name,
                'name_id'=>$name_id,
                'list'=>static::$entity
            ]    
        );
        $id = DB::getPdo()->lastInsertId();
        $count = $request->post('cond_count'); 
        for ($i=1;$i<=$count;$i++) {
            $connection = ($request->post('connection') == 'all')?'':'or';
            $field = $request->post('field'.$i);
            $relation = $request->post('relations'.$i);
            $condition = $request->post('condition'.$i);
            
            DB::table('listfilterconditions')->insert([
                'listfilter_id'=>$id,
                'connection'=>$connection,
                'field'=>$field,
                'relation'=>$relation,
                'condition'=>$condition
            ]);
        }
        return $name_id;
    }
    
    public function filter(string $order = 'id')
    {
        $name = $this->handleFilterDialog();
        $parameters = $this->getRoutingParameters();
        $parameters['page']  = 0;
        $parameters['order'] = $order;
        $parameters['filter'] = $name;
        return redirect(route(static::$route_base.'.list',$parameters));
    }
    
    abstract protected function IDExists($id): bool;
    
    /**
     * Checks if the given id is valid. If yes return true, if not raise a 
     * @param unknown $id
     */
    protected function checkID($id)
    {
        if (!$this->IDExists($id)) {
            throw new InvalidIDException(__("The ID ':id' is not a valid ID.",['id'=>$id]));  
        }
    }
    
    /**
     * Load the data of the data set with the given id
     * @param unknown $id
     */
    abstract protected function getDataSet($id);
    
    protected function getShowParams($id)
    {
        $result = ['entity'=>__(static::$entity)];
        
        $result = array_merge($result, $this->getCommonParameters());
        $result = array_merge($result, ['tables'=>$this->getDataSet($id)]);
        
        return $result;
    }
    /**
     * Shows details of the entity with the given id
     * @param unknown $id = Normally an integer that identifies the entity
     */
    public function show($id)
    {
       
       $template = 'visual::crud.show';
       
       try {
           $this->checkID($id);
           $response = view($template, $this->getShowParams($id));
       } catch (SunhillUserException $e) {
           return $this->exception($e);
       }
       return $response;
    }
    
}