<?php

namespace Sunhill\Visual\Modules;

/**
 * A basic class for differnt kinds of modules
 * @author lokal
 *
 */
class ModuleBase
{
    
    protected $name;
    
    protected $icon;
    
    public function __construct()
    {
        $this->setupModule();
    }
    
    protected function setupModule()
    {
    }
    
    public function setName(string $name)
    {    
        $this->name = $name;
        return $this;
    }
    
    public function getName() : String
    {
        return $this->name;
    }
    
    /**
     * Setter for the icon of this module
     */
    public function setIcon(string $name)
    {
        $this->icon = $name;
        return $this;
    }
    
    /**
     * Getter for the icon of this module
     */
    public function getIcon(): String
    {
        return $this->icon;
    }
}
