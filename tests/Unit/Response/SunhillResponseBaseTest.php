<?php

use Sunhill\Visual\Tests\SunhillVisualTestCase;
use Sunhill\Visual\Response\SunhillResponseBase;
use Sunhill\Visual\Response\SunhillUserException;
use Sunhill\Visual\Modules\SunhillModuleTrait;

class FakeResponseBase extends SunhillResponseBase
{
    use SunhillModuleTrait;
    
    public $fail = false;
    
    protected function prepareResponse()
    {
        if ($this->fail) {
            throw new SunhillUserException('error');
        }
    }
    
    protected function getResponse()
    {
        return "ABC";
    }
    
    
}

/**
 * SunhillResponseBase test case.
 */
class SunhillResponseBaseTest extends SunhillVisualTestCase
{

    /**
     * Tests SunhillResponseBase->getStdClass()
     */
    public function testGetStdClass()
    {
        $test = new SunhillResponseBase();
        
        $result = $this->callProtectedMethod($test,'getStdClass',[['a'=>111,'b'=>222]]);
        
        $this->assertEquals(222,$result->b);
    }
    
    /**
     * Tests SunhillResponseBase->setParams()
     */
    public function testSetParams()
    {
        $test = new SunhillResponseBase();
        
        $test->setParams(['a'=>111,'b'=>222]);
        
        $this->assertEquals(222,$this->getProtectedProperty($test, 'params')['b']);
    }

    /**
     * Tests SunhillResponseBase->mergeParams()
     */
    public function testMergeParams()
    {
        $test = new SunhillResponseBase();
        
        $test->setParams(['a'=>111,'b'=>222]);
        $test->mergeParams(['c'=>333,'d'=>444]);
        
        $this->assertEquals(222,$this->getProtectedProperty($test, 'params')['b']);
        $this->assertEquals(444,$this->getProtectedProperty($test, 'params')['d']);
    }

    /**
     * Tests SunhillResponseBase->response()
     */
    public function testResponse_pass()
    {
       $test = new FakeResponseBase();

       $this->assertEquals('ABC',$test->response());
    }
    
    /**
     * Tests SunhillResponseBase->response()
     */
    public function testResponse_fail()
    {
        $test = new FakeResponseBase();
        $test->fail = true;
        
        $response = $test->response();
        $this->assertEquals(500, $response->getStatusCode());
    }
    
}

