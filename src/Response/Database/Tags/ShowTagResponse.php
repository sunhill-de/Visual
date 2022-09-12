<?php

namespace Sunhill\Visual\Response\Database\Tags;

use Sunhill\Visual\Response\BladeResponse;
use Sunhill\ORM\Facades\Tags;

define("ENTRIES_PER_PAGE", 25);

class ShowTagResponse extends BladeResponse
{

    protected $template = 'visual::tags.show';
        
    protected function prepareResponse()
    {
    }
    
}  
