<?php

/**
 * @file SunhillResponseBase
 * Contains the basic class SunhillResponseBase
 *
 */
namespace Sunhill\Visual\Response;

/**
 * Baseclass for responses. Responses are simplified controller actions.
 * @author klaus
 *
 */
class SunhillResponseBase
{
    
    protected $params;
    
    public function setParams(array $params)
    {
        $this->params = $params;
        return $this;
    }
    
    protected function prepareResponse()
    {
        
    }
    
    protected function getResponse()
    {
        
    }
    
    public function response()
    {
        $this->prepareResponse();
        return $this->getResponse();
    }
}