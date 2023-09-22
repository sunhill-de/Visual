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
    
    protected $name = '';
        
    protected $title = '';
    
    protected $link_route = '';
    
    protected $link_params = [];
    
    protected $link_title = '';
    
    protected $searchable = false;
    
    protected $return_if_null = null;
    
    protected $callback = null;
    
    protected function getDataElement($data_set, $key = '')
    {
        if (empty($key)) {
            $field = $this->field_name;
        } else {
            $field = $key;
        }
        if (is_array($data_set)) {
            return $this->getArrayDataElement($data_set, $field);
        }
        if (is_a($data_set, \StdClass::class)) {
            return $this->getObjectDataElement($data_set, $field);
        }
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
    
    public function getHeaderEntry()
    {
        return $this->getTitle();
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
    
    protected function checkTranslation(string $input)
    {
        return $input;    
    }
    
    public function setLinkTitle(string $link_title): ListEntry
    {
        $this->link_title = $link_title;
        
        return $this;
    }
    
    public function getLinkTitle(): string
    {
        return $this->link_title;    
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
    
    public function link(string $route, array $params): ListEntry
    {
        $this->link_route = $route;
        $this->link_params = $params;
    
        return $this;        
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
    
     
}
