<?php

namespace Sunhill\Visual\Tiles\Computer\Database;

use Sunhill\Visual\Tiles\SunhillTileBase;
use Sunhill\ORM\Facades\Classes;

class AttributesTile extends SunhillTileBase
{
    
    protected $tile_template = 'visual::tiles.database.attributes';
    
    protected function getParams()
    {
        return [
            'number_of_attributes' => Classes::getClassCount()
        ];
    }
}