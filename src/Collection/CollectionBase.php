<?php

namespace Sunhill\Visual\Collection;

/**
 * A Collection is a collection of Module/Feature combinations that belong together and can be implemented by the
 * site itself. 
 * An example would be a Collection of weather informations
 */
class CollectionBase
{
    /**
     * This method should be overwritten by other collections
     */
    protected function doInitCollection()
    {
    }  
  
    /**
     * The public interface. This method insert the given modules and features to the site manager
     */
    public function initCollection()
    {
        $this->doInitCollection();
    }
  
}  
