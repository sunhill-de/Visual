<?php

/**
 * @file ListDescriptor
 * Defines the ListDescriptor class
 *
 */

namespace Sunhill\Visual\Response\Lists;

use Sunhill\Visual\Response\SunhillDescriptor;

/**
 * The ListDescriptor class defines the columns of a SunhillListResponse
 * @author lokal
 *
 */
class ListDescriptor extends SunhillDescriptor
{
    
    protected $groupselect = false;
    
    public function groupselect(bool $value = true)
    {
        $this->groupselect = $value;    
    }
    
    public function getGroupselect(): bool
    {
        return $this->groupselect;    
    }
    
    public function column(string $name): ListEntry
    {        
        return $this->dataField($name);
    }
    
    public function link(string $route, array $route_parameters)
    {
        $entry = new LinkEntry();
        $entry->setRoute($route);
        $entry->setRouteParameters($route_parameters);
        $this->addEntry($entry);
        
        return $entry;
    }
    
    public function dataField(string $field_name)
    {
        $entry = new ListEntry();
        $entry->setFieldName($field_name);
        $this->addEntry($entry);
        
        return $entry;
    }
    
    public function linkableDataField(string $field_name, string $route, array $route_parameters)
    {
        $entry = new LinkEntry();
        $entry->setFieldName($field_name);
        $entry->setRoute($route);
        $entry->setRouteParameters($route_parameters);
        $this->addEntry($entry);
        
        return $entry;
    }

}
