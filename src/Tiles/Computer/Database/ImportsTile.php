<?php

namespace Sunhill\Visual\Tiles\Computer\Database;

use Sunhill\Visual\Tiles\SunhillTileBase;
use Sunhill\ORM\Facades\Classes;

class ImportsTile extends SunhillTileBase
{
    
    protected $tile_template = 'visual::tiles.database.imports';
    
    protected function getParams()
    {
        return [
            'number_of_imports' => Classes::getClassCount()
        ];
    }
}