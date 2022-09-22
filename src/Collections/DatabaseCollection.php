<?php

namespace Sunhill\Visual\Collections;

class DatabaseCollection
{
    /**
     * This method should be overwritten by other collections
     */
    protected function doInitCollection()
    {
        SiteManager::addMainModule('Computer')->setVisible();
        SiteManager::addSubModule('Computer','Database',new ModuleDatabase());
  /*          ->setIcon('computer/computer.png')
            ->setDisplayName(__('Computer'))
            ->setDescription(__('Modules that deal with computers and networks.')); */
        
   }  
