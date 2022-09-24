<?php

namespace Sunhill\Visual\Modules\Infomarket;

use Sunhill\Visual\Modules\ModuleBase;
use Sunhill\Visual\Response\InfoMarket\IndexResponse;

class ModuleInfoMarket extends ModuleBase
{
    
    protected function setupModule()
    {
        $this->setIcon('computer/infomarket.png');  // Icon der Hauptseite
        $this->setName('Infomarket');        // Name der Hauptseite
        $this->setDisplayName('Infomarket');
        $this->setDescription('Anzeigen und Verwalten des Infomarktes'); // Beschreibung
        $this->addSubEntry('index', IndexResponse::class);
    }
        
}
