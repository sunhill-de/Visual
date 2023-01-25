<?php

namespace Sunhill\Visual\Tiles\Computer\Database;

use Sunhill\Visual\Tiles\SunhillTileBase;
use Sunhill\ORM\Facades\Classes;

class TagsTile extends SunhillTileBase
{
    
    protected $tile_template = 'visual::tiles.database.tags';
    
    protected function getParams()
    {
        return [
            'number_of_tags' => Classes::getClassCount()
        ];
    }
}