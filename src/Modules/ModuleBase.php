<?php

namespace Sunhill\Visual\Modules;

use Illuminate\Http\Request;
use Sunhill\Visual\Response\ResponseBase;
use Sunhill\Visual\Entries\EntryBase;

/**
 * A basic class for differnt kinds of modules
 * @author lokal
 *
 */
class ModuleBase extends EntryBase
{
    
    protected $subentries = [];
        
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
    protected function addSubEntry(string $name, $entry, $description="")
    {
        if ($this->findSubEntry($name)) {
            throw new \Exception(__("The sub entry ':name' does already exist.",['name'=>$name]));
        } else if (is_string($entry)) {
            if (method_exists($this,$entry)) {
                $this->subentries[$name] = $entry;
            } else if (class_exists($entry)) {                
              $newentry = new $entry();
              $newentry->setParent($this);
              if (!empty($description)) {
                  $newentry->setDescription($description);
              }        
              $this->subentries[$name] = $newentry;
              return $newentry;
            } else {
               throw new \Exception(__("Can't handle the sub entry ':entry'.",['entry'=>$entry]));
            }    
        } else if (is_a($entry,ModuleBase::class)) {    
            if (!empty($description)) {
                $entry->setDescription($description);
            }        
            $this->subentries[$name] = $entry;           
            $entry->setParent($this);
            return $entry;
        } else if (is_a($entry,ResponseBase::class)) {
            if (!empty($description)) {
                $entry->setDescription($description);
            }        
            $this->subentries[$name] = $entry;
            return $entry;
        } else {
            throw new \Exception(__("Can't handle the sub entry."));
        }    
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
    
    /**
     * The processing works like this:
     * - first check if there is a submodule-entry
     *  - if there is one, check if this is a module
     *    - if yes, pass routing to submodule
     *    - if no, check if this is a response
     *     - if yes, return the response
     *     - if no, check if this is a string
     *      - if yes, check if there is a method action_$string
     *      - if yes, return it
     *      - if no, raise an error
     * - if there is no entry, return false
     */
    protected function doRouting(string $submodule, string $remaining, Request $request, array &$params)
    {
        // No submodule means index
        if ($submodule == '') {
            $submodule = 'index';
        }
        if ($module = $this->findSubEntry($submodule)) {
            $params['breadcrumbs'][] = $this->getBreadcrumb();
            $params['depth'] = $this->getDepth();
            $params['nav_'.$this->getDepth()] = $this->getModuleNavigation();
            $params['prefix'] = $this->getPrefix();
            if ($module instanceof ModuleBase) {
                return $module->route($remaining,$request,$params);
            } else if ($module instanceof ResponseBase) {
                return $module->setRequest($request)->setRemaining($remaining)->setParams($params)->response();
            } else if (is_string($module)) {
                if (method_exists($this,$module)) {
                    return $this->$module($remaining,$request,$params);
                } else {
                    return false;
                }
            } else {                
                throw new \Exception(__("Invalid entry in submodule list."));
            }    
        } else {
            return false;
        }       
     }
    
    /**
     * The internal processing of routes is a little more complicated. Requests are passed from 
     * top modules to bottom modules. Each module adds itself to the breadcrumb. 
     * @param string $path The remaining path, excluding the own path name
     * @param Request $request The complete request
     * @param array $params The params so far
     * @return string|unknown|boolean
     */
    public function route(string $path, Request $request, array &$params)
    {
        $this->setActive(); // Mark it as active (because we routed down)
        $parts = explode('/',$path);
        $submodule = array_shift($parts);
        if (empty($submodule) && !(count($parts) == 0)) {
            $submodule = array_shift($parts);         // Remove first slash    
        }
        $remaining = implode('/',$parts);
        return $this->doRouting($submodule,$remaining,$request,$params);        
    }
    
    public function getLink()
    {
        if ($parent = $this->getParent()) {
            return $parent->getLink().$this->getName().'/';
        } else {
            return '/';
        }
    }
    
    public function getPrefix()
    {
        if (($parent = $this->getParent()) && ($parent->getParent())) {
            return $parent->getPrefix().$parent->getName().'/';
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
            if (is_a($subentry,ModuleBase::class)) {
                $entry = new \StdClass();
                $entry->id = $subentry->getName();
                $entry->name = $subentry->getDescription();
                $entry->depth = $this->getDepth()+1;
                $entry->icon = $subentry->getIcon();
                if (!is_null($subentry->getParent())) {
                    $entry->prefix = $subentry->getParent()->getName();
                } else {
                    $entry->prefix = "";
                }
                $result[] = $entry;
            }
        }
        return $result;
    }
    
    public function getNavigationTree()
    {
        $result = [];
        foreach($this->subentries as $subentry)
        {
            $entry = new \StdClass();
            if (is_a($subentry,ModuleBase::class)) {
                $entry = new \StdClass();
                $entry->id = $subentry->getName();
                $entry->name = $subentry->getDescription();
                $entry->depth = $this->getDepth()+1;
                $entry->icon = $subentry->getIcon();
                $entry->prefix = $subentry->getPrefix();
            } else if (is_a($subentry,ResponseBase::class)) {
            
            }    
            $result[] = $entry;
        }    
        return $result;
    }  
    
    public function getNavigation()
    {
        $result = [];
        foreach($this->subentries as $subentry)
        {
            $entry = new \StdClass();
            if (is_a($subentry,ModuleBase::class)) {
                $entry = new \StdClass();
                $entry->id = $subentry->getName();
                $entry->display_name = $subentry->getName();
                $entry->link = str_replace('//','/',$subentry->getPrefix().'/'.$subentry->getName());
                $entry->name = $subentry->getDescription();
                $entry->depth = $this->getDepth()+1;
                $entry->icon = $subentry->getIcon();
                $entry->prefix = $subentry->getPrefix();
                $entry->active = $subentry->getactive();
                $entry->visible = $subentry->getVisible();
                $entry->subentries = $subentry->getNavigation();
            } else if (is_a($subentry,ResponseBase::class)) {
                $entry = new \StdClass();
            }    
            $result[] = $entry;
        }    
        return $result;
    }    
}
