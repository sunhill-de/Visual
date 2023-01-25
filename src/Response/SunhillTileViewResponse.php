<?php

/**
 * @file SunhillResponseBase
 * Contains the basic class SunhillResponseBase
 *
 */
namespace Sunhill\Visual\Response;

use Sunhill\Visual\Modules\SunhillModuleTrait;

/**
 * Baseclass for responses. Responses are simplified controller actions.
 * @author klaus
 *
 */
class SunhillTileViewResponse extends SunhillBladeResponse
{
    protected $tiles = [];
    
    public function addTile(string $tileclass): SunhillTileViewResponse
    {
        $this->tiles[] = new $tileclass();
        return $this;
    }
    
    protected function prepareResponse()
    {
        parent::prepareResponse();
        $this->template = 'visual::basic.tileview';
        $tiles = [];
        foreach ($this->tiles as $tile) {
            $next_tile = new \StdClass();
            $next_tile->content = $tile->getTile();
            $tiles[] = $next_tile;
        }            
        $this->params['tiles'] = $tiles;
    }
        
}