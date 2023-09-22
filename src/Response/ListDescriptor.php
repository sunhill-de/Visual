<?php

/**
 * @file ListDescriptor
 * Defines the ListDescriptor class
 *
 */

namespace Sunhill\Visual\Response;

/**
 * The ListDescriptor class defines the columns of a SunhillListResponse
 * @author lokal
 *
 */
class ListDescriptor implements \Iterator
{
    
    protected $entries = [];

    protected $current = 0;
    
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
    
    protected function addEntry($entry)
    {
        $this->entries[] = $entry;    
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
    
    public function current(): mixed
    {
        return $this->entries[$this->current];
    }
    
    public function key(): mixed
    {
        return $this->current;    
    }
    
    public function next(): void
    {
        $this->current++;
    }
    
    public function rewind(): void
    {
        $this->current = 0;
    }
    
    public function valid(): bool
    {
       return isset($this->entries[$this->current]);
    }
}
