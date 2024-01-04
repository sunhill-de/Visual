<?php

namespace Sunhill\Visual\Modules;

use Sunhill\ORM\Database\Seeders\SearchStringObjectAssignsTableSeeder;

class SunhillModuleBase
{
    
    protected static $prefix = '';
    
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
    protected $visible = true;
    
    /**
     * Stores the submodules of this modules (if any)
     * @var array
     */
    protected $submodules = [];
    
    /**
     * optional Alias for named routes
     * @var unknown
     */
    protected $alias = '';
    
    
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
     * @test /tests/Unit/SunhillModuleTest::testGetterSetter()
     */
    public function getName(): String
    {
        return is_null($this->name)?"":$this->name;
    }
    
    /**
     * Setter for $this->name
     * @test /tests/Unit/SunhillModuleTest::testGetterSetter()
     */
    public function setDisplayName(string $name): SunhillModuleBase
    {
        $this->display_name = $name;
        return $this;
    }
    
    /**
     * Getter for $this->name
     * @test /tests/Unit/SunhillModuleTest::testGetterSetter()
     */
    public function getDisplayName(): String
    {
        return is_null($this->display_name)?"":$this->display_name;
    }
    
    /**
     * Setter for description
     * @test /tests/Unit/SunhillModuleTest::testGetterSetter()
     */
    public function setDescription(string $description): SunhillModuleBase
    {
        $this->description = $description;
        return $this;
    }
    
    /**
     * Getter for description
     * @test /tests/Unit/SunhillModuleTest::testGetterSetter()
     */
    public function getDescription()
    {
        return is_null($this->description)?"":$this->description;
    }
    
    protected function assertParentNotThis(SunhillModuleBase $parent)
    {
        if ($parent === $this) {
            throw new \Exception("Parent mustn't be this");
        }
    }
    
    /**
     * Setter for parent
     * @test /tests/Unit/SunhillModuleTest::testGetterSetter()
     */
    public function setParent(SunhillModuleBase $parent): SunhillModuleBase
    {
        $this->assertParentNotThis($parent);
        $this->parent = $parent;
        return $this;
    }
    
    /**
     * Getter for parent
     * @test /tests/Unit/SunhillModuleTest::testGetterSetter()
     */
    public function getParent()
    {
        return $this->parent;
    }
    
    /**
     * Setter for active variable
     * @param $value: bool What value should active be (default true)
     * @return $this
     * @test /tests/Unit/SunhillModuleTest::testGetterSetter()
     */
    public function setActive(bool $value=true): SunhillModuleBase
    {
        $this->active = $value;
        return $this;
    }
    
    /**
     * Returns the current value of active
     * @return bool Current value of active
     * @test /tests/Unit/SunhillModuleTest::testGetterSetter()
     */
    public function getActive(): bool
    {
        return $this->active;
    }
    
    /**
     * Setter for visible variable
     * @param $value: bool Is this entry visible
     * @return $this
     * @test /tests/Unit/SunhillModuleTest::testGetterSetter()
     */
    public function setVisible(bool $value=true): SunhillModuleBase
    {
        $this->visible = $value;
        return $this;
    }
    
    /**
     * Returns the current value of visible
     * @return bool Current value of visible
     * @test /tests/Unit/SunhillModuleTest::testGetterSetter()
     */
    public function getVisible(): bool
    {
        return $this->visible;
    }
    
    /**
     * Setter for alias
     * @param string $alias
     * @return SunhillModuleBase
     */
    public function setAlias(string $alias): SunhillModuleBase
    {
        $this->alias = $alias;
        return $this;
    }
    
    /**
     * Getter for alias
     * @return String
     */
    public function getAlias(): String
    {
        return $this->alias;    
    }
    
    public function __construct()
    {
        $this->setupModule();        
    }
    
    protected function setupModule()
    {
    }
    
    /**
     * Adds the given submodule to the internal submodule storage
     * @param SunhillModuleBase $submodule
     * @test /tests/Unit/SunhillModuleTest::testAddSubmoduleEntry()
     */
    protected function addSubmoduleEntry(SunhillModuleBase $submodule)
    {
        $submodule->setParent($this);
        $this->submodules[$submodule->getName()] = $submodule;
    }
    
    /**
     * Adds given submodule to internal storage and calls $callback with the submodule as param (if callable) 
     * @param SunhillModuleBase $submodule
     * @param unknown $callback
     * @test /tests/Unit/SunhillModuleTest::testSubmodule()
     */
    public function addSubmodule(SunhillModuleBase $submodule, $callback = null)
    {
        if (is_callable($callback)) {
            $callback($submodule);
        }
        $this->addSubmoduleEntry($submodule);
    }
    
    /**
     * Adds an submodule with the given parameters
     * @param string $name
     * @param string $display_name
     * @param string $description
     * @param unknown $callback
     * @return SunhillModuleBase
     * @test /tests/Unit/SunhillModuleTest::testAddDefaultSubmodule()
     */
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
    
    /**
     * Return the (translated) display name for this module
     * @param string $display_name
     * @param string $name
     * @return \Sunhill\Visual\Modules\string|string|array|NULL
     * @test /tests/Feature/SunhillModuleTest::testGetCurrentDisplayName()
     */
    protected function getCurrentDisplayName(string $display_name, string $name)
    {
        if (empty($display_name)) {
            return __($name);
        }
        return __($display_name);
    }
    
    /**
     * Adds a default index response to this module
     * @param unknown $controller
     * @param string $action
     * @test /tests/Feature/SunhillModuleTest::testAddIndex()
     */
    public function addIndex($controller, string $action="index")
    {
        return $this->addAction('index')->addControllerAction([$controller, $action])->setVisible(false);
    }
    
    /**
     * Adds an action to this module
     * @param string $name
     * @param string $display_name
     * @param string $description
     * @param bool $visible
     * @return \Sunhill\Visual\Modules\SunhillAction
     * @test /tests/Feature/SunhillModuleTest::testAddAction()
     */
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
    
    /**
     * Installs the routes of all submodules to laravel
     * @test /tests/Feature/SunhillModuleTest::testInstallRoutes()
     */
    public function installRoutes()
    {
        foreach ($this->submodules as $submodule) {
            $submodule->installRoutes();
        }
    }
    
    /**
     * If there is a parent return its route otherwise return empty string
     * @return string
     * @test /tests/Unit/SunhillModuleTest::testGetParentRoute()
     */
    protected function getParentRoute()
    {
        if (!empty($this->parent)) {
            return $this->parent->getRoute();
        }
        return '';
    }

    /**
     * If name is index return empty string otherwise name
     * @return string|\Sunhill\Visual\Modules\string
     * @test /tests/Unit/SunhillModuleTest::testGetRouteName()
     */
    protected function getRouteName()
    {
        if (empty($this->parent) || ($this->name == 'index')) {
            return '';
        }
        return $this->name;
    }

    /**
     * Return the path of the parent and add own path to it
     * @return string
     * @test /tests/Unit/SunhillModuleTest::testGetRoute()
     */
    public function getRoute()
    {
        return $this->getLink();
    }
    
    public function getLink()
    {
        $parent = $this->getParentRoute();
        $result = ($parent == '/')?'/'.$this->getRouteName():$parent.'/'.$this->getRouteName();
        if (empty($result)) {
            return '/';
        }
        return $result;        
    }
    
    /**
     * Creates a stdclass object with the given parameters
     * @param array $params
     * @return \StdClass
     * @test /tests/Unit/SunhillModuleTest::testGetStdclass()        
     */
    protected function getStdClass(array $params)
    {
        $result = new \StdClass();
        foreach ($params as $key => $value) {
            $result->$key = $value;
        }
        return $result;
    }

    /**
     * If the remaining path $path is found in the submodule called $module return it 
     * otherwise return null
     * @param string $module
     * @param string $path
     * @return \Sunhill\Visual\Modules\SunhillModuleBase|unknown|NULL
     */
    protected function hasActiveModule(string $module, string $path)
    {
        if (empty($module)) {
            return null;
        }
        if (empty($path)) {
            return isset($this->submodules[$module])?$this->submodules[$module]:null;
        }
        if (isset($this->submodules[$module])) {
            return $this->submodules[$module]->getActiveModule($path);
        }
        return null;
    }
    
    protected function cleanPath(string $path)
    {
        $path = str_replace('//','/',$path);
        if (substr($path,0,1) == '/') {
            $path = substr($path,1);
        }
        if (substr($path,-1) == '/') {
            $path = substr($path,0,-1);
        }
        return $path;
    }
    
    protected function implodeOrEmpty(string $glue, array $items)
    {
        if (empty($items)) {
            return "";
        }
        return implode($glue, $items);
    }
    
    public function getActiveModule(string $path)
    {
        $path = $this->cleanPath($path);
        $parts = explode('/',$path);
        $module = array_shift($parts);
        if (is_null($module)) {
            $module = "";
        }
        return $this->hasActiveModule($module,$this->implodeOrEmpty('/',$parts));
    }
    
    public function getModuleOfLevel(string $path, int $level=1)
    {
        if ($level <= 0) {
            return $this;
        }
        if (empty($path)) {
            return null;
        }
        $parts = explode('/',$this->cleanPath($path));
        $module = array_shift($parts);
        $path = implode('/',$parts);
        if (isset($this->submodules[$module])) {
            return $this->submodules[$module]->getModuleOfLevel($path, $level -1);
        }
        return null;
    }
    
    protected function addBreadcrumb(array &$breadcrumbs)
    {
        if (!is_null($this->getParent())) {
            $this->getParent()->addBreadcrumb($breadcrumbs);
        }
        $breadcrumbs[] = $this->getStdClass(['name'=>__($this->getDisplayName()),'link'=>$this->getRoute()]);
    }
    
    public function getBreadcrumbs()
    {
        $result = [];
        $this->addBreadcrumb($result);
        return $result;
    }
    
    protected function handleSubLinks(SunhillModuleBase $module, bool $add_sublinks)
    {
        if ($add_sublinks) {
            return $module->getNavigationLinks($add_sublinks);
        }
        return [];
    }
    
    protected function processModule(SunhillModuleBase $module, bool $add_sublinks)
    {
        return $this->getStdClass([
            'name'=>$module->getName(),
            'display_name'=>$module->getDisplayName(),
            'link'=>$module->getLink(),
            'subentries'=>$this->handleSubLinks($module, $add_sublinks)
        ]);            
    }
    
    public function getNavigationLinks(bool $add_sublinks = false) 
    {
        $result = [];
        foreach ($this->submodules as $module) {
            if ($module->getVisible()) {
                $result[] = $this->processModule($module, $add_sublinks);
            }
        }    
        return $result;
    }
}
