<?php

namespace Sunhill\Visual\Modules;

/**
 * A crud module provides all crud features (list, show, filtered list, add, edit and delete. If 
 * set then there is a feature groupedit and groupdelete too.
 * @author klaus
 *
 */
abstract class SunhillCrudModule extends SunhillSemiCrudModule
{
 
    protected function setupCrud()
    {
        parent::setupCrud();
        $this->addAction('Add')
             ->addControllerAction([static::$controller, 'add'])
             ->setVisible(true)
             ->setAlias(static::$route_base.'.add');
        $this->addAction('ExecAdd')
             ->setMethod('post')
             ->addControllerAction([static::$controller, 'execadd'])
             ->setVisible(false)
             ->setAlias(static::$route_base.'.execadd');
        $this->addAction('Edit')
             ->addControllerAction([static::$controller, 'edit'])
             ->setRouteAddition('/{id}')
             ->setVisible(false)
             ->setAlias(static::$route_base.'.edit');
        $this->addAction('ExecEdit')
             ->setMethod('post')
             ->addControllerAction([static::$controller, 'execedit'])
             ->setRouteAddition('/{id}')
             ->setVisible(false)
             ->setAlias(static::$route_base.'.execedit');
        $this->addAction('Delete')
             ->addControllerAction([static::$route_base, 'delete'])
             ->setVisible(false)
             ->setRouteAddition('/{id}')
             ->setAlias(static::$route_base.'.delete');
    }
    
}