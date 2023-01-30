<?php

/**
 * @file SunhillResponseBase
 * Contains the basic class SunhillResponseBase
 *
 */
namespace Sunhill\Visual\Response;

use Sunhill\Visual\Facades\SunhillSiteManager;

/**
 * Baseclass for responses. Responses are simplified controller actions.
 * @author klaus
 *
 */
class SunhillResponseBase
{
    
    protected $params;
    
    /**
     * Creates a stdclass object with the given parameters
     * @param array $params
     * @return \StdClass
     * @test /tests/Unit/SunhillModuleTest::testGetStdclass()
     */
    protected function getStdClass(array $params)
    {
        $result = new \StdClass();
        foreach ($params as $key => $value) {
            $result->$key = $value;
        }
        return $result;
    }
    
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