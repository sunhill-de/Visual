<?php

namespace Sunhill\Visual\Response\Database\Classes;

use Sunhill\Visual\Response\SunhillBladeResponse;
use Sunhill\ORM\Facades\Classes;

class ShowClassResponse extends SunhillBladeResponse
{
    
    protected $template = 'visual::classes.show';
    
    protected $class = '';
    
    public function setClass(string $class)
    {
        $this->class = $class;
        return $this;
    }
    
    public function prepareResponse()
    {
        parent::prepareResponse();
    }
}  
