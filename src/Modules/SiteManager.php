<?php

namespace Sunhill\Visual\Modules;

class SiteManager extends ModuleBase
{
    /**
     * Tries to route the given request inside the 
     * @param Request $request
     */
    public function tryToRoute(Request $request): Response
    {
        $params = [
            'sitename'=>$this->getName(),
            'breadcrumbs'=>$this->getBreadcrumb()
        ];
        $path = $request->path();
        if ($result = $this->route($path,$request,$params))
        {
            return $result;
        } else {
            return $this->error404($request);
        }
    }
    
    protected function error404(Request $request): Response
    {
        return view('error.404');
    }
}
