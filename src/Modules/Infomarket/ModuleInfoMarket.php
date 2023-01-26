<?php

namespace Sunhill\Visual\Modules\Infomarket;

use Sunhill\Visual\Modules\SunhillModuleBase;

class ModuleInfoMarket extends SunhillModuleBase
{
    
    protected function setupModule()
    {
        $this->setName('Infomarket');        // Name der Hauptseite
        $this->setDisplayName('Infomarket');
        $this->setDescription('Anzeigen und Verwalten des Infomarktes'); // Beschreibung
        $this->addIndex(\Sunhill\Visual\Controllers\Infomarket\InfomarketController::class);
    }
        
}
