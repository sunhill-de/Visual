<?php

namespace Sunhill\Visual\Collections;

/**
 * A Collection is a collection of Module/Feature combinations that belong together and can be implemented by the
 * site itself. 
 * An example would be a Collection of weather informations
 */
class CollectionBase
{
    public function __construct()
    {
        $this->doInitCollection();
    }    
    
    /**
     * This method should be overwritten by other collections
     */
    protected function doInitCollection()
    {
    }  
  
}  
