<?php

namespace Sunhill\Visual\Collections;

use Sunhill\Visual\Modules\Infomarket\ModuleInfoMarket;
use Sunhill\Visual\Facades\SiteManager;

class InfoMarketCollection extends CollectionBase
{
    /**
     * This method should be overwritten by other collections
     */
    protected function doInitCollection()
    {
        SiteManager::addMainModule('Computer')->setVisible();
        SiteManager::addSubModule('Computer','Infomarket',new ModuleInfoMarket())
            ->setVisible()
            ->setIcon('computer/infomarket.png')
            ->setDisplayName(__('Infomarket'));
    }

}
