<?php

namespace Sunhill\Visual\Tiles\Computer\Database;

use Sunhill\Visual\Tiles\SunhillTileBase;
use Sunhill\ORM\Facades\Classes;

class ObjectsTile extends SunhillTileBase
{
    
    protected $tile_template = 'visual::tiles.database.objects';
    
    protected function getParams()
    {
        return [
            'number_of_objects' => Classes::getClassCount()
        ];
    }
}