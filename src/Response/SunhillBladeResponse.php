<?php

/**
 * @file SunhillBlaseResponse
 * Basic class that return blade templates
 *
 */
namespace Sunhill\Visual\Response;

use Sunhill\Visual\Modules\SunhillModuleTrait;

/**
 * Baseclass for responses. Responses are simplified controller actions.
 * @author klaus
 *
 */
class SunhillBladeResponse extends SunhillResponseBase
{
    
    use SunhillModuleTrait;
    
    protected $template;
    
    protected function prepareResponse()
    {
        parent::prepareResponse();
        $this->setParams($this->getBasicParams());
    }
    
    protected function getResponse()
    {
        return view($this->template, $this->params);        
    }
    
}