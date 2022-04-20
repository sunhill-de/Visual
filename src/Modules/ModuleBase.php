<?php

namespace Sunhill\Visual\Modules;

use Illuminate\Http\Request;

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
    
    protected $parent = null;
    
    protected $description = "";
    
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
            $newentry->setParent($this);
            $this->subentries[$name] = $newentry;
            return $newentry;
        } else if (is_a($entry,ModuleBase::class)) {    
            $this->subentries[$name] = $entry;           
            $entry->setParent($this);
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
    
    public function setDescription(string $description)
    {
        $this->description = $description;
        return $this;
    }
    
    public function getDescription() : String
    {
        return $this->description;
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
    
    public function setParent(ModuleBase $parent): ModuleBase
    {
        $this->parent = $parent;
        return $this;
    }
    
    public function getParent()
    {
        return $this->parent;    
    }
    
    /**
     * The internal processing of routes is a little more complicated. Requests are passed from 
     * top modules to bottom modules. Each module adds itself to the breadcrumb. If there is no 
     * submodule, try to find a method with this name and the prefix "action_" and call this. 
     * If this isn't found either, return false
     * @param string $path The remaining path, excluding the own path name
     * @param Request $request The complete request
     * @param array $params The params so far
     * @return string|unknown|boolean
     */
    public function route(string $path, Request $request, array &$params)
    {
        $parts = explode('/',$path);
        $submodule = array_shift($parts);
        if (empty($submodule) && !(count($parts) == 0)) {
            $submodule = array_shift($parts);         // Remove first slash    
        }
        $remaining = implode('/',$parts);
        
        if (($submodule == '') && (method_exists($this,'action_index'))) {
            return $this->action_index($request,$params);
        } else if ($module = $this->findSubEntry($submodule)) {
            $params['breadcrumbs'][] = $this->getBreadcrumb();
            $params['nav_'.$this->getDepth()] = $this->getModuleNavigation();
            return $module->route($remaining,$request,$params);
        } else if (method_exists($this,'action_'.$submodule)){
            $method = 'action_'.$submodule;
            $params['depth'] = $this->getDepth();
            return $this->$method($remaining,$request,$params);
        } else  {
            return false;
        }
    }
    
    public function getLink()
    {
        if ($parent = $this->getParent()) {
            return $parent->getLink().$this->getName().'/';
        } else {
            return '/';
        }
    }
    
    public function getBreadcrumb()
    {
        $result = new \StdClass();
        $result->name = $this->getName();
        $result->link = $this->getLink();
        return $result;
    }
    
    public function getDepth()
    {
        if ($parent = $this->getParent()) {
            return $parent->getDepth()+1;
        } else {
            return 0;
        }
    }
    
    public function getModuleNavigation()
    {
        $result = [];
        foreach ($this->subentries as $subentry) {
            $entry = new \StdClass();
            $entry->id = $subentry->getName();
            $entry->name = $subentry->getDescription();
            $entry->depth = $this->getDepth()+1;
            $entry->icon = $subentry->getIcon();
            $result[] = $entry;
        }
        return $result;
    }
}
