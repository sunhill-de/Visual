<?php

namespace Sunhill\Visual\Modules;

/**
 * A basic class for differnt kinds of modules
 * @author lokal
 *
 */
class ModuleBase
{
    
    protected $subentries = [];
    
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
    protected function findSubEntry(string $name)
    {
        if (isset($this->subentries[$name])) {
            return $this->subentries[$name];
        } else {
            return false;
        }
    }
    
    /**
     * Tries to add a sub entity to the tree. First it searches, if this entity is already in the tree
     * if yes, it raises an excpetion otherwise it is added to the tree
     * @param $name The name of the entry to add
     * @param $entry string|ModuleBase either a string of an ModuleBase class or a already initiated object of a ModuleBase class
     */
    protected function addSubEntry(string $name, $entry)
    {
        if ($this->findSubEntry($name)) {
            throw new \Exception("The sub entry '$name' does already exist.");
        } else if (is_string($entry)) {
            $newentry = new $entry();
            $this->subentries[$name] = $newentry;
            return $newentry;
        } else if (is_a($entry,ModuleBase::class)) {    
            $this->subentries[$name] = $entry;           
            return $entry;
        } else {
            throw new \Exception("Can't handle the sub entry.");
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
