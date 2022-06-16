<?php

namespace Sunhill\Visual\Response\Database;

use Sunhill\Visual\Response\BladeResponse;

class ListObjectsResponse extends BladeResponse
{

    protected $template = 'visual::objects.list';
    
    protected function prepareResponse()
    {
        $parts = explode('/',$this->remaining);
        if (count($parts) == 0) {
            $this->params['object'] = 'ORMObject';
        } else {
            $this->params['object'] = $parts[0];
        }
    }
}  
