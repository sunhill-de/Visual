<?php

namespace Sunhill\Visual\Response\Database\Objects;

use Sunhill\Visual\Response\BladeResponse;
use Sunhill\ORM\Facades\Tags;

class EditTagResponse extends BladeResponse
{

    protected $template = 'visual::tags.edit';
        
    protected function prepareResponse()
    {
    }
    
}  
