<?php

namespace Sunhill\Visual\Response\Database\Tags;

use Sunhill\Visual\Response\BladeResponse;
use Sunhill\ORM\Facades\Tags;

class ShowTagResponse extends BladeResponse
{

    protected $template = 'visual::tags.show';
        
    protected function prepareResponse()
    {
    }
    
}  
