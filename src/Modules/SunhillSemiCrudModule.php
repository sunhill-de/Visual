<?php

namespace Sunhill\Visual\Modules;

/**
 * A semi crud module doesn't provide add and edit features only list, filter and show
 * @author klaus
 *
 */
abstract class SunhillSemiCrudModule extends SunhillModuleBase
{
 
    protected static $route_base = '';
    
    protected static $controller = '';
    
    abstract protected function setupBasics();
    
    protected function setupCrud()
    {
        $this->addIndex(static::$controller);
        $this->addAction('List')
            ->addControllerAction([static::$controller, 'list'])
            ->setVisible(true)
            ->setRouteAddition(static::$prefix.'/{page?}/{order?}/{filter?}')
            ->setAlias(static::$route_base.'.list');
        $this->addAction('Show')
            ->addControllerAction([static::$controller, 'show'])
            ->setVisible(false)
            ->setRouteAddition(static::$prefix.'/{id}')
            ->setAlias(static::$route_base.'.show');
        $this->addAction('Filter')
            ->addControllerAction([static::$controller, 'filter'])
            ->setRouteAddition(static::$prefix.'/{order?}')
            ->setMethod('POST')
            ->setVisible(false)
            ->setAlias(static::$route_base.'.filter');
    }
    
    protected function setupAdditional()
    {
        
    }
    
    protected function setupModule()
    {
        $this->setupBasics();
        $this->setupCrud();
        $this->setupAdditional();
    }
}