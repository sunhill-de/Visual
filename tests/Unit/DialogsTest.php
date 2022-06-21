<?php

namespace Sunhill\Visual\Tests\Unit;

use Sunhill\Visual\Facades\Dialogs;
use Sunhill\ORM\Objects\ORMObject;
use Sunhill\Visual\Response\ResponseBase;
use Sunhill\Basic\Tests\SunhillTestCase;
use Sunhill\Visual\Tests\CreatesApplication;

class TestObject extends ORMObject
{
    
}

class ChildObject extends TestObject
{
    
}

class DummyObject extends ORMObject
{
    
}

class TestResponse extends ResponseBase
{
   
   protected function getResponse()
   {
        return "ABC";    
   }
   
}

class DialogsTest extends SunhillTestCase
{
  
  use CreatesApplication;
  
  public function testGetClassName($param,$expect)
  {
        try {
            $this->assertEquals($expect,Dialogs::getClassName($param));
        } catch (\Exception $e)
        {
            if ($expect == 'except') {
                $this->assertTrue(true);
                return;
            }
        }
  }
  
  public function getClassNameProvider()
  {
        return [
            
        ];    
  }
    
  public function testGetResponse()
  {
      Dialogs::addResponse('add', TestObject::class, TestReponse::class);
      $response = Dialogs::getResponse('add', TestObject::class);
      $this->assertEquals('ABC', $response->response());
  }
  
  public function testGetChildResponse()
  {
      Dialogs::addResponse('add', TestObject::class, TestReponse::class);
      $response = Dialogs::getResponse('add', ChildObject::class);
      $this->assertEquals('ABC', $response->response());
  }
  
  public function testGetNoResponse()
  {
      Dialogs::addResponse('add', TestObject::class, TestReponse::class);
      $response = Dialogs::getResponse('add', DummyObject::class);
      $this->assertTrue(is_null($response));
  }
  
}  
