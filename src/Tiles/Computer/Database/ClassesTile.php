<?php

namespace Sunhill\Visual\Tiles\Computer\Database;

use Sunhill\Visual\Tiles\SunhillTileBase;
use Sunhill\ORM\Facades\Classes;

class ClassesTile extends SunhillTileBase
{
    
    protected $tile_template = 'visual::tiles.database.classes';
    
    protected function getParams()
    {
        return [
            'number_of_classes' => Classes::getClassCount()
        ];
    }
}