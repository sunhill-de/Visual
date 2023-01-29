<?php

namespace Sunhill\Visual\Modules;

use Illuminate\Support\Facades\Route;

class SunhillAction extends SunhillModuleBase
{

    protected $controller = [];
    
    protected $method = 'get';
    
    protected $route_addition = '';
        
    /**
     * Checks if the given array has exactly 2 entries. If not raises an exception
     * @param array $test
     * @throws \Exeption
     */
    protected function assertTwoParts(array $test)
    {
        if (count($test) !== 2) {
            throw new \Exeption("Invalid count of entries. Expected 2, got ".count($test));
        }
    }

    /**
     * Adds the given controller array to this action
     * @param array $controller
     */
    protected function addControllerActionArray(array $controller)
    {
        $this->assertTwoParts($controller);
        $this->controller = $controller; 
        return $this;
    }
        
    public function addControllerAction($controller, string $action="")
    {
        if (is_array($controller)) {
            return $this->addControllerActionArray($controller);
        }
        if (is_string($controller) && is_empty($action)) {
            $parts = explode('@',$controller);
            return $this->addControllerActionArray($parts);
        }
        if (is_string($controller)) {
            return $this->addControllerActionArray([$controller, $action]);
        }
        throw new \Exception("Unknown action.");
    }
    
    /**
     * If the http verb is something else than get change it with this method
     * @param string $method
     */
    public function setMethod(string $method)
    {
        $this->method = $method;
        return $this;
    }
    
    public function setRouteAddition(string $route_addition)
    {
        $this->route_addition = $route_addition;
        return $this;
    }
    
    public function getRoute()
    {
        return parent::getRoute().$this->route_addition;
    }
    
    protected function calculateDefaultController()
    {
        $route_parts = explode('/',$this->getRoute());
        $action = array_pop($route_parts);
        
        for ($i=0;$i<count($route_parts);$i++) {
            $route_parts[$i] = ucfirst($route_parts[$i]);
        }
        
    }
    
    /**
     * If the controller field is not empty return it, otherwise calculate a default controller
     * @return unknown
     */
    protected function getController()
    {
        if (!empty($this->controller)) {
            return $this->controller;
        }
        return $this->calculateDefaultController();
    }
    
    /**
     * 
     */
    public function installRoutes()
    {
        $method     = $this->method;
        $route = str_replace('//','/',$this->getRoute());
        $controller = $this->getController();
        Route::$method($this->getRoute(), $this->getController());    
    }
   
    public function getActiveModule(string $path)
    {
        return $this;
    }
}