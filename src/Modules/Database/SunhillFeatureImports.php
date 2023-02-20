<?php

namespace Sunhill\Visual\Modules\Database;

use Sunhill\Visual\Response\Database\Classes\ListClassesResponse;

use Sunhill\Visual\Modules\SunhillModuleBase;

class SunhillFeatureImports extends SunhillModuleBase
{
    
    protected function setupModule()
    {
        $this->setName('Imports');
        $this->setDisplayName('Imports');        
        $this->setDescription('Imports');
        $this->addIndex(\Sunhill\Visual\Controllers\Database\ImportsController::class);
        $this->addAction('Movies')
            ->addControllerAction([\Sunhill\Visual\Controllers\Database\ImportsController::class, 'ListMovies'])
            ->setVisible(true)
            ->setRouteAddition('/{page?}');
        $this->addAction('ShowMovie')
            ->addControllerAction([\Sunhill\Visual\Controllers\Database\ImportsController::class, 'ShowMovie'])
            ->setVisible(false)
            ->setRouteAddition('/{id}');
        $this->addAction('EditMovie')
            ->addControllerAction([\Sunhill\Visual\Controllers\Database\ImportsController::class, 'EditMovie'])
            ->setVisible(false)
            ->setRouteAddition('/{id}');
        $this->addAction('DeleteMovie')
            ->addControllerAction([\Sunhill\Visual\Controllers\Database\ImportsController::class, 'DeleteMovie'])
            ->setVisible(false)
            ->setRouteAddition('/{id}');
        $this->addAction('LookupMovie')
            ->setDisplayName('Lookup movie')
            ->addControllerAction([\Sunhill\Visual\Controllers\Database\ImportsController::class, 'Lookupmovie'])
            ->setVisible(false)
            ->setRouteAddition('/{id}');
    }
    
    
}
