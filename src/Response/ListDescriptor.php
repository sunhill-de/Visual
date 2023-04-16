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
class ListDescriptor
{
    
    public function column(string $name): ListDescriptor
    {
        return $this;
    }
    
    public function title(string $title) : ListDescriptor
    {
        return $this;
        
    }
    
    public function link(string $route, array $params): ListDescriptor
    {
        return $this;
        
    }
    
    public function searchable(): ListDescriptor
    {
        return $this;
    }
}
