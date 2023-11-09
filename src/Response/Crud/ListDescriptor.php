<?php

/**
 * @file ListDescriptor
 * Defines the ListDescriptor class
 *
 */

namespace Sunhill\Visual\Response\Crud;

use Sunhill\Visual\Response\SunhillDescriptor;

/**
 * The ListDescriptor class defines the columns of a SunhillListResponse
 * @author lokal
 *
 */
class ListDescriptor extends SunhillDescriptor
{
    
    protected $data_callback;
    
    protected $parent_parameters = [];
    
    public function setParentParameters($parent_parameters)
    {
        $this->parent_parameters = $parent_parameters;
    }
    
    public function setDataCallback(callable $callback)
    {
        $this->data_callback = $callback;
        return $this;
    }

    public function getDataCallback()
    {
        return $this->data_callback;    
    }
    
    public function column(string $name): ListEntry
    {        
        return $this->dataField($name);
    }
    
    public function link(string $route, array $route_parameters)
    {
        $entry = new LinkEntry();
        $entry->setRoute($route);
        $entry->setParentRoutingParameters($this->parent_parameters);
        $entry->setRouteParameters($route_parameters);
        $this->addEntry($entry);
        
        return $entry;
    }
    
    public function dataField(string $field_name)
    {
        $entry = new ListEntry();
        $entry->setFieldName($field_name);
        $entry->setParentRoutingParameters($this->parent_parameters);
        $this->addEntry($entry);
        
        return $entry;
    }
    
    public function linkableDataField(string $field_name, string $route, array $route_parameters)
    {
        $entry = new LinkEntry();
        $entry->setFieldName($field_name);
        $entry->setRoute($route);
        $entry->setRouteParameters($route_parameters);
        $entry->setParentRoutingParameters($this->parent_parameters);
        $this->addEntry($entry);
        
        return $entry;
    }

}
