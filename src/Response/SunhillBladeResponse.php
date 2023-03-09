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
    
    public function setTemplate(string $template)
    {
        $this->template = $template;    
    }
    
    protected function prepareResponse()
    {
        parent::prepareResponse();
        if (is_array($this->params)) {
            $this->params = array_merge($this->params, $this->getBasicParams());
        } else {
            $this->params = $this->getBasicParams();            
        }
    }
    
    protected function getResponse()
    {
        return view($this->template, $this->params);        
    }
    
}