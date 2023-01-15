<?php

namespace Sunhill\Visual\Modules;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Sunhill\Visual\Entries\EntryBase;

class SiteManager extends ModuleBase
{
    
    protected $icon = '';

    protected $name = '';
    
    protected $description = '';
    
    public function setIcon($name): EntryBase
    {
        $this->icon = $name;
        return $this;
    }
    
    public function setName($name): EntryBase
    {
        $this->name = $name;
        return $this;
    }
    
    public function setDescription($name): EntryBase
    {
        $this->description = $name;
        return $this;
    }
    
    public function getParameters($breadcrumbs)
    {
        $result = [
            'nav_1'=>$this->getLevel1(),
            'breadcrumbs'=>[]            
        ];
        
        return $result;
    }
    
    /**
     * Tries to route the given request inside the 
     * @param Request $request
     */
    public function tryToRoute(Request $request)
    {        
        $path = $request->path();
        $params = [
            'nav_1' => $this->getLevel1(),
            'sitename'=>$this->getDescription(),
            'breadcrumbs'=>[]
        ];
        if ($result = $this->route($path,$request,$params))
        {
            $params['nav_2'] = $this->getLevel2();
            $params['nav_3'] = $this->getLevel3();
            return $result->setParams($params)->response();
        } else {
            return $this->error404($request,$params);
        }
    }
    
    protected function getLevel1()
    {
        return $this->getNavigation(1);    
    }
    
    protected function getLevel2()
    {
        if ($active = $this->getActiveSubmodule()) {
            return $active->getNavigation(2);
        }
    }
    
    protected function getLevel3()
    {
        if (($active = $this->getActiveSubmodule()) && ($subactive = $active->getActiveSubmodule())) {
            return $subactive->getNavigation(3);
        }
    }
    
    protected function error404(Request $request,$params)
    {
        return view('error.404',$params);
    }
    
    public function addModule(string $name, $entry, $description="")
    {
        return $this->addSubEntry($name, $entry, $description);
    }
}
