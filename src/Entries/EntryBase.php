<?php

namespace Sunhill\Visual\Entries;

use Sunhill\Visual\Modules\ModuleBase;

/**
 * A base class for Modules and Responses. Capsulates the basic handling of name, description and so on
 * @author Klaus Dimde
 */
class EntryBase
{
    /**
     * The name of this entry
     */
    protected $name;
  
    /**
     * The name of this entry to display (can be translated)
     */
    protected $display_name;
  
    /**
     * A description of this entry
     */
    protected $description;
  
    /**
     * The parent module of this entry
     */
    protected $parent;

    /**
     * Marks if this module is currently active
     * @var bool
     */
    protected $active = false;
    
    /**
     * Marks if this module is currently visible in the navigation
     * @var boolean
     */
    protected $visible = false;
    
    /**
     * Setter for $this->name
     */
    public function setName(string $name): EntryBase
    {
        $this->name = $name;
        return $this;
    }
  
    /**
     * Getter for $this->name
     */
    public function getName(): String
    {
        return is_null($this->name)?"":$this->name;
    }  
  
    /**
     * Setter for $this->name
     */
    public function setDisplayName(string $name): EntryBase
    {
        $this->display_name = $name;
        return $this;
    }
  
    /**
     * Getter for $this->name
     */
    public function getDisplayName(): String
    {
        return is_null($this->display_name)?"":$this->display_name;
    }  
  
    /**
     * Setter for description
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
        return $this;
    }
    
    /**
     * Getter for description
     */
    public function getDescription()
    {
        return is_null($this->description)?"":$this->description;
    }   

    /**
     * Setter for parent 
     */
    public function setParent(ModuleBase $parent): EntryBase
    {
        $this->parent = $parent;
        return $this;
    }
    
    /**
     * Getter for parent
     */
    public function getParent()
    {
        return $this->parent;    
    }

    /**
     * Setter for active variable
     * @param $value: bool What value should active be (default true)
     * @return $this     
     */
    public function setActive(bool $value=true)
    {
        $this->active = $value;
        return $this;
    }
    
    /**
     * Returns the current value of active
     * @return bool Current value of active
     */
    public function getActive(): bool
    {
        return $this->active;
    }
    
    /**
     * Setter for visible variable
     * @param $value: bool Is this entry visible
     * @return $this     
     */
    public function setVisible(bool $value=true)
    {
        $this->visible = $value;
        return $this;
    }
    
    /**
     * Returns the current value of visible
     * @return bool Current value of visible
     */
    public function getVisible(): bool
    {
        return $this->visible;
    }
    
    /**
     * Returns a link to this entry
     * @returns string
     */
    public function getLink()
    {
        if ($parent = $this->getParent()) {
            return $parent->getLink().$this->getName().'/';
        } else {
            return '/';
        }
    }
    
    /**
     * Returns the link to the parent module
     * @returns string
     */
    public function getPrefix()
    {
        if (($parent = $this->getParent()) && ($parent->getParent())) {
            return $parent->getPrefix().$parent->getName().'/';
        } else {
            return '/';
        }
    }
    
    /**
     * Returns the module depth (how many parent modules are there)
     * @returns int
     */
    public function getDepth()
    {
        if ($parent = $this->getParent()) {
            return $parent->getDepth()+1;
        } else {
            return 0;
        }
    }

    /**
     * Creates a StdClass from the input @param $input
     * @param unknown $input
     * @return \StdClass
     */
    protected function createStdClass(array $input): \StdClass
    {
        $return = new \StdClass();
        foreach ($input as $key => $value) {
            $return->$key = $value;
        }
        return $return;
    }
}
