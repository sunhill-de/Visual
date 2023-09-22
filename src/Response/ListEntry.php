<?php

/**
 * @file ListEntry
 * Defines the ListEntry class
 *
 */

namespace Sunhill\Visual\Response;

/**
 * The ListEntry class represents a single column in a list view
 * @author lokal
 *
 */
class ListEntry
{
    protected $column_title = '';
    
    protected $column_sortable = false;
    
    protected $field_name = '';
    
    protected $title = '';
    
    protected $link_route = '';
    
    protected $link_params = [];
    
    protected $link_title = '';
    
    protected $searchable = false;
    
    protected $callback = null;
    
    protected $class = null;
    
    /**
     * Setter for class. With setClass it is possible to pass a css class that is used for the header
     * cell tag (like is-narrow)
     * @param string $class
     * @return ListEntry
     */
    public function setClass(string $class): ListEntry
    {
        $this->class = $class; 
        return $this;
    }
    
    /**
     * Setter for link_title. With setLinkTitle it is possible to pass a fixed string to a cell that is
     * displayed in every row (like 'delete')
     * @param string $link_title
     * @return ListEntry
     */
    public function setLinkTitle(string $link_title): ListEntry
    {
        $this->link_title = $link_title;
        
        return $this;
    }
    
    /**
     * Getter for link_title
     * @return string
     */
    public function getLinkTitle(): string
    {
        return $this->link_title;
    }
    
    public function setCallback($callback): ListEntry
    {
        $this->callback = $callback;
        
        return $this;
    }
    
    /**
     * Sets the field name for columns that access the data source
     * @param string $field_name
     * @return DataListEntry
     */
    public function setFieldName(string $field_name): ListEntry
    {
        $this->field_name = $field_name;
        
        return $this;
    }
    
    public function getFieldName(): string
    {
        return $this->field_name;
    }
    
    /**
     * Sets the title of the column. This will be passed to __()
     * @param string $column_title
     * @return \Sunhill\Visual\Response\ListEntry
     */
    public function setColumnTitle(string $column_title)
    {
        $this->column_title = $column_title;
        return $this;
    }
    
    /**
     * Returns the title of the column.
     * @return string
     */
    public function getColumnTitle(): string
    {
        if (empty($this->column_title)) {
            return '';
        }
        return __($this->column_title);
    }
    
    /**
     * Marks (by default value) the given column as sortable
     * @param bool $column_sortable
     * @return \Sunhill\Visual\Response\ListEntry
     */
    public function setColumnSortable(bool $column_sortable = true)
    {
        $this->column_sortable = $column_sortable;
        return $this;
    }
    
    /**
     * Returns if this column in sortable
     * @return bool
     */
    public function getColumnSortable(): bool
    {
        return $this->column_sortable;
    }
    
    public function getName(): string
    {
        return $this->name;
    }
    
    public function title(string $title) : ListEntry
    {
        $this->title = $title;
        
        return $this;
    }
    
    public function getTitle(): string
    {
        return __($this->title);
    }
    
    public function searchable(bool $searchable = true): ListEntry
    {
        $this->searchable = $searchable;
        
        return $this;
    }
    
    public function getSearchable(): bool
    {
        return $this->searchable;
    }
    
    protected function getDataElement($data_set, $key = '')
    {
        if (empty($key)) {
            $field = $this->field_name;
        } else {
            $field = $key;
        }
        if (!is_null($this->callback)) {
            return $this->getCallbackDataElement($data_set, $field);
        }
        if (is_array($data_set)) {
            return $this->getArrayDataElement($data_set, $field);
        }
        if (is_a($data_set, \StdClass::class)) {
            return $this->getObjectDataElement($data_set, $field);
        }
    }
    
    protected function getCallbackDataElement($data_set, string $field)
    {
        $callback = $this->callback;
        return $callback($data_set, $field);    
    }
    
    protected function getObjectDataElement(\StdClass $data_set, string $field)
    {
        if (property_exists($data_set, $field)) {
            return $data_set->$field;
        } else {
            return "NE";
        }
    }
    
    protected function getArrayDataElement(array $data_set, string $field)
    {
        if (array_key_exists($field, $data_set)) {
            return $data_set[$field];
        } else {
            return "NE";
        }
    }
    
    protected function createHeaderEntry($title, $class = null)
    {
        $result = new \StdClass();
        $result->title = $title;
        $result->class = $class;
        return $result;
    }
    
    public function getHeaderEntry()
    {
        return $this->createHeaderEntry($this->getTitle(), $this->class);
    }
    
    public function getDataEntry($data_set)
    {
        if (empty($this->link_route)) {
            return $this->getSimpleEntry($data_set);
        } else {
            return $this->getLinkedEntry($data_set);            
        }
    }
    
    protected function getSimpleEntry($data_set)
    {
        return e($this->checkTranslation($this->getDataElement($data_set)));        
    }
    
    protected function getLinkedEntry($data_set)
    {
        return '<a href="'.$this->getLinkTarget($data_set).'">'.$this->getLinkText($data_set).'</a>';
    }
    
    protected function getLinkTarget($data_set)
    {
        return asset(route($this->link_route,$this->getRoutingParameters($data_set)));
    }
    
    protected function getLinkText($data_set)
    {
        if (empty($this->getLinkTitle())) {
            return e($this->checkTranslation($this->getDataElement($data_set)));
        } else {
            return e(__($this->getLinkTitle()));            
        }
    }
    
    protected function getRoutingParameters($data_set)
    {
        $return = [];
        foreach ($this->link_params as $key => $value) {
            $return[$key] = $this->getDataElement($data_set, $value);
        }
        return $return;    
    }
    
    protected function checkTranslation($input)
    {
        if (empty($input)) {
            return '';
        }
        return $input;    
    }
    
    public function link(string $route, array $params): ListEntry
    {
        $this->link_route = $route;
        $this->link_params = $params;
    
        return $this;        
    }
    
    
     
}
