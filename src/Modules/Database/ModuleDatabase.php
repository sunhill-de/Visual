<?php

namespace Sunhill\Visual\Modules\Database;

use Sunhill\Visual\Modules\ModuleBase;
use Sunhill\Visual\Response\Database\IndexResponse;
use Sunhill\Visual\Modules\Database\FeatureObjects;
use Sunhill\Visual\Modules\Database\FeatureClasses;
use Sunhill\Visual\Modules\Database\FeatureTags;

class ModuleDatabase extends ModuleBase
{
    
    protected function setupModule()
    {
        $this->setIcon('computer/database.png');  // Icon der Hauptseite
        $this->setName('Database');        // Name der Hauptseite
        $this->setDisplayName('Datenbank');
        $this->setDescription('Verwaltung der Datenbank'); // Beschreibung
        $this->addSubEntry('index', IndexResponse::class);
        $this->addSubEntry('Tags', FeatureTags::class)
            ->setVisible()
            ->setName('Tags')
            ->setDisplayName(__('Tags'));
        $this->addSubEntry('Import', FeatureImport::class)
            ->setVisible()
            ->setName('Import')
            ->setDisplayName(__('Import'));
    }
        
}
