<?php

namespace Sunhill\Visual\Managers;

use Sunhill\Visual\Modules\SunhillModuleBase;
use Sunhill\Visual\Modules\SunhillAction;
use Illuminate\Support\Facades\Blade;

class SunhillSiteManager extends SunhillModuleBase
{
     
    protected $css_resources = [];
    
    protected $js_resources = [];
    
    protected $ajax_modules = [];
    
    public function getCurrentBreadcumbs()
    {
        if ($active_module = $this->getActiveModule(request()->path())) {
            return $active_module->getBreadcrumbs();   
        }            
        return [];
    }
    
    public function getMainNavigation()
    {
          return $this->getNavigationLinks();
    }
     
    public function getSubNavigation()
    {
         if ($submodule = $this->getModuleOfLevel(request()->path(),1)) {
               return $submodule->getNavigationLinks();
         }     
         return [];
    }
    
    public function get3rdLevelNavigation()
    {
          if ($module = $this->getModuleOfLevel(request()->path(),2)) {
               return $module->getNavigationLinks(true);
          }
         return [];
    }
    
    /**
     * Returns the current active Module defined by the actual path
     * @return \Sunhill\Visual\Modules\SunhillModuleBase|\Sunhill\Visual\Modules\unknown|NULL|NULL
     */
    public function getCurrentEndpoint()
    {
        return $this->getActiveModule(request()->path());
    }

    protected function getPathOf($module)
    {
        if (is_null($module)) {
            return '';
        }
        return $module->getLink();
    }
    
    public function getCurrentEndpointPath()
    {
        return $this->getPathOf($this->getCurrentEndpoint());
    }
    
    /**
     * Returns the current feature. That means if the current module is a action, it returns it parent otherwise
     * the current module. 
     * @return unknown|NULL
     */
    public function getCurrentFeature()
    {
        if (($active_module = $this->getCurrentEndpoint())) {
            if (is_a($active_module,SunhillAction::class)) {
                return $active_module->getParent();
            } else {
                return $active_module;
            }
        }
        return null;
    }
    
    public function getCurrentFeaturePath()
    {
        return $this->getPathOf($this->getCurrentFeature());    
    }
    
    /**
     * returns the current submodule
     * @return unknown|NULL
     */
    public function getCurrentSubModule()
    {
        if (($active_feature = $this->getCurrentFeature())) {
            return $active_feature->getParent();
        }
        return null;
    }
    
    public function getCurrentSubModulePath()
    {
        return $this->getPathOf($this->getCurrentSubModule());    
    }
    
    public function getCurrentMainModule()
    {
        $path_parts = explode('/',request()->path());
        $module_name = array_shift($path_parts);
        return $this->getActiveModule($module_name);        
    }

    public function getCurrentMainModulePath()
    {
        return $this->getPathOf($this->getCurrentMainModule());    
    }

    /**
     * Adds a module css resource to the global sunhill css composer
     * @param string $path
     *
     * Test: Unit/Managers/DialogManager/DialogManagerResourceTest::testaddCSSResources()
     */
    public function addCSSResource(string $path)
    {
        $this->css_resources[] = $path;
    }
    
    /**
     * Adds a module js resource to the global sunhill js composer
     * @param string $path
     *
     * Test: Unit/Managers/DialogManager/DialogManagerResourceTest::testaddJSResources()
     */
    public function addJSResource(string $path)
    {
        $this->js_resources[] = $path;
    }
    
    /* Builds together all css files of the project and returns the result
     *
     * Test: Unit/Managers/DialogManager/DialogManagerResourceTest::testComposeCSS()
     */
    public function composeCSS()
    {
        $content = view('visual::basic.build',[
            'files'=>$this->getFiles('css')
        ]);
        return response($content)->header('Content-Type','text/css');
    }
    
    /* Builds together all js files of the project and returns the result
     *
     * Test: Unit/Managers/DialogManager/DialogManagerResourceTest::testComposeJS()
     */
    public function composeJS()
    {
        $content = view('visual::basic.build',[
            'files'=>$this->getFiles('js')
        ]);
        return response($content)->header('Content-Type','text/javascript');
    }
    
    protected function getFiles(string $resources)
    {
        $result = [];
        $resources = $resources.'_resources';
        foreach ($this->$resources as $dir) {
            $this->composeDir($result, $dir);
        }
        return $result;
    }
    
    protected function composeDir(array &$result, string $effective_dir)
    {
        $files = [];
        if (!file_exists($effective_dir)) {
            return;
        }
        $d = dir($effective_dir);
        while (false !== ($entry = $d->read())) {
            if (is_file($effective_dir.'/'.$entry)) {
                $files[] = $effective_dir.'/'.$entry;
            }
        }
        $d->close();
        sort($files);
        foreach ($files as $file) {
            $result[] = Blade::render(file_get_contents($file));
        }
    }
    
    public function addAjaxModule(string $name, string $module)
    {
        $this->ajax_modules[$name] = $module;
    }
    
    public function getAjaxModule(string $name)
    {
        if (!array_key_exists($name, $this->ajax_modules)) {
            return;
        }
        $namespace = $this->ajax_modules[$name];
        $result = new $namespace();
        
        return $result;
    }
}
