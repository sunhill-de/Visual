<?php

namespace Sunhill\Visual\Response\InfoMarket;

use Sunhill\Visual\Response\BladeResponse;
use Sunhill\InfoMarket\Facades\InfoMarket;

class IndexResponse extends BladeResponse
{
    
    protected $template = 'visual::infomarket.index';
 
    protected function prepareResponse()
    {
       $this->params['entries'] = InfoMarket::getOffer(false); 
       
        
    }
}