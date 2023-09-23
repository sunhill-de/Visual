<?php

/**
 * @file SunhillListResponse
 * Basic class that return blade templates
 *
 */
namespace Sunhill\Visual\Response\Dialog;

use Sunhill\Visual\Response\SunhillBladeResponse;

class SunhillDialogResponse extends SunhillBladeResponse
{

    protected $route = '';
    
    protected $route_parameters = [];
    
    public function setRoute(string $route, array $parameters): SunhillDialog
    {
        $this->route = $route;
        $this->route_parameters = $parameters;
        return $this;
    }
}
