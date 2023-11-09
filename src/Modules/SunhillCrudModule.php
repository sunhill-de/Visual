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
 
    protected function providesGroupDelete(): bool
    {
        return static::$controller::providesGroupDelete();
    }
    
    protected function providesGroupEdit(): bool
    {
        return static::$controller::providesGroupEdit();        
    }
    
    protected function setupCrud()
    {
        parent::setupCrud();
        $this->addAction('Add')
             ->addControllerAction([static::$controller, 'add'])
             ->setVisible(true)
             ->setRouteAddition(static::$prefix)
             ->setAlias(static::$route_base.'.add');
        $this->addAction('ExecAdd')
             ->setMethod('post')
             ->addControllerAction([static::$controller, 'execadd'])
             ->setRouteAddition(static::$prefix)
             ->setVisible(false)
             ->setAlias(static::$route_base.'.execadd');
        $this->addAction('Edit')
             ->addControllerAction([static::$controller, 'edit'])
             ->setRouteAddition(static::$prefix.'/{id}')
             ->setVisible(false)
             ->setAlias(static::$route_base.'.edit');
        $this->addAction('ExecEdit')
             ->setMethod('post')
             ->addControllerAction([static::$controller, 'execedit'])
             ->setRouteAddition(static::$prefix.'/{id}')
             ->setVisible(false)
             ->setAlias(static::$route_base.'.execedit');
        $this->addAction('Delete')
             ->addControllerAction([static::$controller, 'delete'])
             ->setVisible(false)
             ->setRouteAddition(static::$prefix.'/{id}')
             ->setAlias(static::$route_base.'.delete');
        if ($this->providesGroupDelete()) {
            $this->addAction('ConfirmGroupDelete')
                 ->addControllerAction([static::$controller, 'confirmgroupdelete'])
                 ->setMethod('post')
                 ->setVisible(false)
                 ->setRouteAddition(static::$prefix)
                 ->setAlias(static::$route_base.'.confirmgroupdelete');            
            $this->addAction('ExecGroupDelete')
                 ->addControllerAction([static::$controller, 'execgroupdelete'])
                 ->setMethod('post')
                 ->setVisible(false)
                 ->setRouteAddition(static::$prefix)
                 ->setAlias(static::$route_base.'.execgroupdelete');
        }
        
        if ($this->providesGroupEdit()) {
            $this->addAction('GroupEdit')
                 ->addControllerAction([static::$controller, 'groupedit'])
                 ->setMethod('post')
                 ->setVisible(false)
                 ->setRouteAddition(static::$prefix)
                 ->setAlias(static::$route_base.'.groupedit');
            $this->addAction('ExecGroupEdit')
                 ->addControllerAction([static::$controller, 'execgroupedit'])
                 ->setMethod('post')
                 ->setVisible(false)
                 ->setRouteAddition(static::$prefix)
                 ->setAlias(static::$route_base.'.execgroupedit');            
        }
    }
    
}