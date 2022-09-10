<?php

namespace Sunhill\Visual\Modules;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SiteManager extends ModuleBase
{
    /**
     * Tries to route the given request inside the 
     * @param Request $request
     */
    public function tryToRoute(Request $request)
    {        
        $params = [
            'navigation'=>$this->getNavigation(),
            'nav_0'=>$this->getModuleNavigation(),
            'sitename'=>$this->getDescription(),            
            'breadcrumbs'=>[]
        ];
        $path = $request->path();
        if ($result = $this->route($path,$request,$params))
        {
            return $result;
        } else {
            return $this->error404($request,$params);
        }
    }
    
    protected function error404(Request $request,$params)
    {
        return view('error.404',$params);
    }
    
}
