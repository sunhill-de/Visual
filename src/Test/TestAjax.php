<?php

namespace Sunhill\Visual\Test;

use Sunhill\Visual\Response\Ajax\AjaxResponse;

class TestAjax extends AjaxResponse
{
    
    protected $dummy_data = [
        'Iron Maiden'=>1,
        'Judas Priest'=>2,
        'Manowar'=>3,
        'Def Leppard'=>4,
        'Slayer'=>5,
        'Metallica'=>6,
        'DIO'=>7,
        'Saxon'=>8,
        'Rush'=>9,
        'Riot'=>10,
        'Kreator'=>11,
        'Dissection'=>12,
        'AC/DC'=>13,
        'Motörhead'=>14,
        'Megadeth'=>15
    ];
    
    protected function assembleOutput(string $search)
    {
        $result = [];
        foreach ($this->dummy_data as $entry => $id) {
            if (strpos($entry, $search) !== false) {
                $result[] = $this->makeStdclass(['label'=>$entry,'id'=>$id]);
            }
        }
        return $result;
    }
    
}