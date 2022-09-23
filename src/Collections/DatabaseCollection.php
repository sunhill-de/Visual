<?php

namespace Sunhill\Visual\Collections;

use Sunhill\Visual\Modules\Database\ModuleDatabase;
use Sunhill\Visual\Facades\SiteManager;

class DatabaseCollection extends CollectionBase
{
    /**
     * This method should be overwritten by other collections
     */
    protected function doInitCollection()
    {
        SiteManager::addMainModule('Computer')->setVisible();
        SiteManager::addSubModule('Computer','Database',new ModuleDatabase())->setVisible();
  /*          ->setIcon('computer/computer.png')
            ->setDisplayName(__('Computer'))
            ->setDescription(__('Modules that deal with computers and networks.')); */
        
    }

}
