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
    use AccessData;
   
    protected $name = '';
        
    protected $title = '';
    
    protected $link_route = '';
    
    protected $link_params = [];
    
    protected $searchable = false;
    
    public function __construct(string $name)
    {
        $this->name = $name;    
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
    
    protected function getCurrentParams($current)
    {
        $result = [];
        
        foreach ($this->link_params as $key => $value) {
            $result[$key] = $this->accessData($current, $value); 
        }
        
        return $result;
    }
    
    public function getLink($current)
    {
        if (empty($this->link_route)) {
           return null;  
        } 
        return route($this->link_route, $this->getCurrentParams($current));
    }
    
    public function getLinkRoute(): string
    {
        return $this->link_route;    
    }
    
    public function getLinkParams(): array
    {
        return $this->link_params;
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
