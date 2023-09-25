<?php

/**
 * @file SunhillDescriptor
 * Defines a basic iterable list of entries
 *
 */

namespace Sunhill\Visual\Response;

/**
 * The SunhillDescriptor is a base class for ListDescriptor and DialogDescriptor that provides the 
 * possibility to iterate over this list
 * @author lokal
 *
 */
class SunhillDescriptor implements \Iterator
{
    
    protected $entries = [];

    protected $current = 0;
    
    protected function addEntry($entry)
    {
        $this->entries[] = $entry;    
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
