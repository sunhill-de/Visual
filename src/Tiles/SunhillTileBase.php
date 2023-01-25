<?php

namespace Sunhill\Visual\Tiles;

class SunhillTileBase
{

    protected $tile_template;
    
    public function setTemplate(string $template)
    {
        $this->tile_template = $template;    
    }
    
    protected function getParams()
    {
        return [];    
    }
    
    public function getTile()
    {
        return view($this->tile_template,$this->getParams())->render();
    }
}
