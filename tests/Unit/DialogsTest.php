<?php

namespace Sunhill\Visual\Tests\Unit;

use Sunhill\Visual\Facades\Dialogs;
use Sunhill\Visual\Managers\DialogManager;
use Sunhill\ORM\Objects\ORMObject;
use Sunhill\Visual\Response\ResponseBase;
use Sunhill\Basic\Tests\SunhillTestCase;
use Sunhill\Visual\Tests\CreatesApplication;
use Sunhill\ORM\Facades\Classes;

class TestObject extends ORMObject
{
    public static $table_name = 'testobjects';
    
    public static $object_infos = [
        'name'=>'TestObject',       // A repetition of static:$object_name @todo see above
        'table'=>'testobjects',     // A repitition of static:$table_name
        'name_s' => 'testobject',
        'name_p' => 'testobjects',
        'description' => 'Test class 1',
        'options'=>0,           // Reserved for later purposes
    ];
    
}

class ChildObject extends TestObject
{
    public static $table_name = 'childobjects';
    
    public static $object_infos = [
        'name'=>'ChildObject',       // A repetition of static:$object_name @todo see above
        'table'=>'childobjects',     // A repitition of static:$table_name
        'name_s' => 'childobject',
        'name_p' => 'childobjects',
        'description' => 'Test class 2',
        'options'=>0,           // Reserved for later purposes
    ];
    
}

class DummyObject extends ORMObject
{
    public static $table_name = 'dummyobjects';
    
    public static $object_infos = [
        'name'=>'DummyObject',       // A repetition of static:$object_name @todo see above
        'table'=>'dummyobjects',     // A repitition of static:$table_name
        'name_s' => 'dummyobject',
        'name_p' => 'dummyobjects',
        'description' => 'Test class 3',
        'options'=>0,           // Reserved for later purposes
    ];
    
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
  
  protected function setupClasses()
  {
      Classes::flushClasses();
      Classes::registerClass(TestObject::class);
      Classes::registerClass(ChildObject::class);
      Classes::registerClass(DummyObject::class);
  }
  
  /**
   * @dataProvider getClassNameProvider
   * @param unknown $param
   * @param unknown $expect
   */
  public function testGetClassName($param,$expect)
  {
      $this->setupClasses();  
      $test = new DialogManager();
      try {
            $this->assertEquals($expect,$this->callProtectedMethod($test, 'getClassName',[$param]));
        } catch (\Exception $e)
        {
            if ($expect == 'except') {
                $this->assertTrue(true);
                return;
            } else {
                throw $e;
            }
        }
  }
  
  public function getClassNameProvider()
  {
        return [
            [TestObject::class,TestObject::class],
            ['noneexisting','except'],
            ['TestObject',TestObject::class]
        ];    
  }
  
  /**
   * @dataProvider getBestEntryProvider
   * @param unknown $array
   * @param unknown $test
   * @param unknown $expect
   */
  public function testGetBestEntry($array,$test_item,$expect)
  {
      $this->setupClasses();
      $test = new DialogManager();
      $this->assertEquals($expect,$this->callProtectedMethod($test, 'getBestEntry', [$array,$test_item]));
  }
  
  public function getBestEntryProvider()
  {
        return [
            [[ORMObject::class=>'AAA',TestObject::class=>'BBB'],TestObject::class,'BBB'],
            [[ORMObject::class=>'AAA'],TestObject::class,'AAA'],
            [[ORMObject::class=>'AAA',TestObject::class=>'BBB'],ChildObject::class,'BBB'],
        ];    
  }
  
  public function testGetObjectResponse()
  {
      $this->setupClasses();
      Dialogs::addObjectResponse('add', TestObject::class, TestReponse::class);
      $response = Dialogs::getObjectResponse('add', TestObject::class);
      $this->assertEquals('ABC', $response->response());
  }
  
  public function testGetChildResponse()
  {
      $this->setupClasses();
      Dialogs::addObjectResponse('add', TestObject::class, TestReponse::class);
      $response = Dialogs::getObjectResponse('add', ChildObject::class);
      $this->assertEquals('ABC', $response->response());
  }
  
  public function testGetNoResponse()
  {
      $this->setupClasses();
      Dialogs::addObjectResponse('add', TestObject::class, TestReponse::class);
      $response = Dialogs::getObjectResponse('add', DummyObject::class);
      $this->assertTrue(is_null($response));
  }
  
}  
