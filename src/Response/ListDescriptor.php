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
    
    public function column(string $name): ListEntry
    {        
        $entry = new ListEntry($name);
        $this->entries[] = $entry;
        
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
