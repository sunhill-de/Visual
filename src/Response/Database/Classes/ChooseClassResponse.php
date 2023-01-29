<?php

namespace Sunhill\Visual\Response\Database\Classes;

use Sunhill\Visual\Response\SunhillBladeResponse;
use Sunhill\ORM\Facades\Classes;

class ChooseClassResponse extends SunhillBladeResponse
{
    
    protected $template = 'visual::classes.choose';
    
    protected $action = '';
    
    public function setAction(string $action)
    {
        $this->action = $action;
        return $this;
    }
    
    public function prepareResponse()
    {
        parent::prepareResponse();
    }
}  
