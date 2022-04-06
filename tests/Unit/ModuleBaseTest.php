<?php

namespace Sunhill\Visual\Tests\Unit;

use Sunhill\Visual\Modules\ModuleBase;

class SubModule extends ModuleBase
{
}

class TestModule extends ModuleBase
{
}

class ModuleBaseTest extends TestCase
{
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
    $this->assertEquals('Test',$this->callProtectedMethod($test,'findSubEntry',['Test']));
  }  
      
  public function testAddAndFindSubentryByClassName()
  {
    $test = new SubModule();
    $this->assertTrue(is_a($this->callProtectedMethod($test,'addSubEntry',['Test',SubModule::class]),SubModule::class);
  }  

}  
