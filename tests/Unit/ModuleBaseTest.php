<?php

namespace Sunhill\Visual\Tests\Unit;

use Sunhill\Visual\Modules\ModuleBase;
use Sunhill\Visual\Tests\CreatesApplication;
use Sunhill\Basic\Tests\SunhillTestCase;
use Illuminate\Http\Request;

class SubModule extends ModuleBase
{
    protected function action_test(string $path, Request $request, array &$params)
    {
        return "TEST";
    }
    
    protected function action_params(string $path, Request $request, array &$params)
    {
        return "TEST".$path;    
    }
    
    protected function action_index(Request $request, array &$params)
    {
        return "INDEX";
    }
    
}

class TestModule extends ModuleBase
{
    protected function setupModule()
    {
        $this->addSubEntry('sub', new SubModule())->setName('sub');
    }
}

class ModuleBaseTest extends SunhillTestCase
{
  
  use CreatesApplication;
    

  public function testName()
  {
     $test = new SubModule();
     $test->setName('Test');
     $this->assertEquals('Test',$test->getName());
  }
  
  public function testIcon()
  {
     $test = new SubModule();
     $test->setIcon('Test');
     $this->assertEquals('Test',$test->getIcon());
  }
  
  public function testFindSubentryFail()
  {
    $test = new SubModule();
    $this->assertFalse($this->callProtectedMethod($test,'findSubEntry',['NotExisting']));
  }
  
  public function testAddAndFindSubentryByObject()
  {
    $test = new SubModule();
    $subentry = new SubModule();
    $subentry->setName('Test');
    $this->callProtectedMethod($test,'addSubEntry',['Test',$subentry]);
    $this->assertEquals('Test',$this->callProtectedMethod($test,'findSubEntry',['Test'])->getName());
  }  
      
  public function testAddAndFindSubentryByClassName()
  {
    $test = new SubModule();
    $this->assertTrue(is_a($this->callProtectedMethod($test,'addSubEntry',['Test',SubModule::class]),SubModule::class));
  }  

  public function testGetParent()
  {
      $test = new SubModule();
      $subentry = new SubModule();
      $subentry->setName('Test');
      $this->callProtectedMethod($test,'addSubEntry',['Test',$subentry]);
      $this->assertEquals($test,$subentry->getParent());      
  }
  
  public function testGetDepth()
  {
      $test = new SubModule();
      $subentry = new SubModule();
      $subentry->setName('Test');
      $this->callProtectedMethod($test,'addSubEntry',['Test',$subentry]);
      $this->assertEquals(0,$test->getDepth());
      $this->assertEquals(1,$subentry->getDepth());
  }
  
  public function testGetBreadcrumb()
  {
      $test = new SubModule();
      $test->setName('main');
      $subentry = new SubModule();
      $subentry->setName('sub');
      $this->callProtectedMethod($test,'addSubEntry',['sub',$subentry]);
      $this->assertEquals(['name'=>'sub','link'=>'/sub/'],$subentry->getBreadcrumb());      
  }

  public function testRouteExisting()
  {
      $test = new SubModule();
      $request = new Request();
      $params = [];
      $this->assertEquals("TEST",$test->route('/test',$request,$params));      
  }
  
  public function testRouteWithParams()
  {
      $test = new SubModule();
      $request = new Request();
      $params = [];
      $this->assertEquals("TEST3",$test->route('/params/3',$request,$params));
  }
  
  public function testRouteIndex()
  {
      $test = new SubModule();
      $request = new Request();
      $params = [];
      $this->assertEquals("INDEX",$test->route('/',$request,$params));      
  }
  
  public function testDownRouting()
  {
      $test = new TestModule();
      $request = new Request();
      $params = [];
      $this->assertEquals("INDEX",$test->route('/sub',$request,$params));
      
  }
  
  public function testDownRouting2()
  {
      $test = new TestModule();
      $request = new Request();
      $params = [];
      $this->assertEquals("TEST",$test->route('/sub/test',$request,$params));
      
  }
  
  public function testRouteNotExisting()
  {
      $test = new SubModule();
      $request = new Request();
      $params = [];
      $this->assertFalse($test->route('/notexisting',$request,$params));
  }
}  
