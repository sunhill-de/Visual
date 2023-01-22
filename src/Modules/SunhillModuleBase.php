<?php

namespace Sunhill\Visual\Modules;

class SunhillModuleBase
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
     * Stores the submodules of this modules (if any)
     * @var array
     */
    protected $submodules = [];
    
    /**
     * Setter for $this->name
     */
    public function setName(string $name): SunhillModuleBase
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
    public function setDisplayName(string $name): SunhillModuleBase
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
    public function setDescription(string $description): SunhillModuleBase
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
    public function setParent(SunhillModuleBase $parent): SunhillModuleBase
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
    public function setActive(bool $value=true): SunhillModuleBase
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
    public function setVisible(bool $value=true): SunhillModuleBase
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
     * Adds the given submodule to the internal submodule storage
     * @param SunhillModuleBase $submodule
     */
    protected function addSubmoduleEntry(SunhillModuleBase $submodule)
    {
        $submodule->setParent($this);
        $this->submodules[$submodule->getName()] = $submodule;
    }
    
    public function addSubmodule(SunhillModuleBase $submodule, $callback = null)
    {
        if (is_callable($callback)) {
            $callback($submodule);
        }
        $this->addSubmoduleEntry($submodule);
    }
    
    public function addDefaultSubmodule(
                            string $name, 
                            string $display_name = '', 
                            string $description = '', 
                            $callback = null): SunhillModuleBase
    {
        $submodule = new SunhillModuleBase();
        $submodule->setName($name);
        $submodule->setDisplayName($display_name);
        $submodule->setDescription($description);
        $this->addSubmodule($submodule, $callback);
        return $submodule;
    }
    
    protected function getCurrentDisplayName(string $display_name, string $name)
    {
        if (empty($display_name)) {
            return $name;
        }
        return __($display_name);
    }
    
    public function addIndex($controller, string $action="index")
    {
        $this->addAction('index')->addControllerAction([$controller, $action]);
    }
    
    public function addAction(string $name, 
                              string $display_name = "", 
                              string $description = "", 
                              bool $visible = false)
    {
        $action = new SunhillAction();
        $action->setName($name)
            ->setDisplayName($this->getCurrentDisplayName($display_name,$name))
            ->setVisible($visible)
            ->setDescription($description);
        $this->addSubmoduleEntry($action);
        return $action;
    }
    
    public function installRoutes()
    {
        foreach ($this->submodules as $submodule) {
            $submodule->installRoutes();
        }
    }
    
    protected function getParentRoute()
    {
        if (!empty($this->parent)) {
            return $this->parent->getRoute();
        }
        return '';
    }
    
    protected function getRouteName()
    {
        if ($this->name == 'index') {
            return '';
        }
        return $this->name;
    }
    
    public function getRoute()
    {
        return $this->getParentRoute().'/'.$this->getRouteName();    
    }
    
    protected function getStdClass(array $params)
    {
        $result = new \StdClass();
        foreach ($params as $key => $value) {
            $result->$key = $value;
        }
        return $result;
    }
    
    protected function hasActiveModule(string $module, string $path)
    {
        if (empty($path)) {
            return $this;
        }
        if (isset($this->submodules[$module])) {
            return $this->submodule[$module]->getActiveModule($path);
        }
        return null;
    }
    
    protected function getActiveModule(string $path)
    {
        $parts = explode('/',$path);
        $module = array_pop($parts);
        return $this->hasActiveModule($module,implode('/',$parts));
    }
    
    protected function addBreadcrumb(array &$breadcrumbs)
    {
        if (!is_null($this->getParent())) {
            $this->getParent()->addBreadcrumb($breadcrumbs);
        }
        $breadcrumbs[] = $this->getStdClass(['name'=>$this->getDisplayName(),'link'=>'/']);
    }
    
    public function getBreadcrumbs()
    {
        $result = [];
        $this->addBreadcrumb($result);
        return $result;
    }
}