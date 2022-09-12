<?php

namespace Sunhill\Visual\Response\Database\Objects;

use Sunhill\Visual\Response\BladeResponse;
use Sunhill\ORM\Facades\Tags;

class AddTagResponse extends BladeResponse
{

    protected $template = 'visual::tags.add';
        
    protected function prepareResponse()
    {
    }
    
}  
