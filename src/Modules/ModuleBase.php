<?php

namespace Sunhill\Visual\Modules;

/**
 * A basic class for differnt kinds of modules
 * @author lokal
 *
 */
class ModuleBase
{
    
    protected $tree = [];
    
    protected $name = "";
    
    protected $icon = "";
    
    public function __construct()
    {
        $this->setupModule();
    }
    
    protected function setupModule()
    {
    }
    
    /**
     * Searches the tree for a SubEntity with the given name
     * It return a ModuleBase object if found otherwise false
     * @param $name string The name of the subentity to search
     */
    protected function findSubEntity(string $name)
    {
        if (isset($this->tree[$name])) {
            return $this->tree[$name];
        } else {
            return false;
        }
    }
    
    /**
     * Tries to add a sub entity to the tree. First it searches, if this entity is already in the tree
     * if yes, it raises an excpetion otherwise it is added to the tree
     */
    protected function addSubEntity(string $name, $entity)
    {
        if ($this->findSubEnitity($name)) {
            throw new \Exception("The sub entitiy '$name' does already exist.");
        } else {
            $this->tree[$name] = $group;           
        }    
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
