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
    
    protected $error_response;
    
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
    
    protected function setError(SunhillResponseBase $error_response)
    {
        $this->error_response = $error_response;    
    }
    
    public function setParams(array $params)
    {
        $this->params = $params;
        return $this;
    }
    
    public function mergeParams(array $params)
    {
        $this->params = array_merge($this->params, $params);
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
        try {
            $this->prepareResponse();
            return $this->getResponse();
        } catch (SunhillUserException $e) {
            report($e);
            $params = $this->getBasicParams();
            $params['e'] = $e;
            return response()->view('visual::basic.usererror',$params, 500);
        }
    }
}