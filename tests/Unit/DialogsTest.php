<?php

namespace Sunhill\Visual\Tests\Unit;

use Sunhill\Visual\Facades\Dialogs;
use Sunhill\Visual\Managers\DialogManager;
use Sunhill\Visual\Tests\SunhillVisualTestCase;

use Sunhill\ORM\Objects\ORMObject;
use Sunhill\Visual\Response\SunhillResponseBase;
use Sunhill\Visual\Tests\CreatesApplication;
use Sunhill\ORM\Facades\Classes;

use Sunhill\ORM\Tests\DBSearchTestCase;
use Sunhill\ORM\Utils\ObjectList;
use Sunhill\ORM\Facades\Objects;
use Sunhill\ORM\Tests\Objects\SearchtestA;
use Sunhill\ORM\Tests\Objects\SearchtestB;
use Sunhill\ORM\Tests\Objects\SearchtestD;

class TestObject extends ORMObject
{
    
    protected static function setupInfos()
    {
        static::addInfo('name','TestObject');
        static::addInfo('table','testobjects');
        static::addInfo('name_s','test object',true);
        static::addInfo('name_p','test objects',true);
        static::addInfo('description','Test object for visual test', true);
        static::addInfo('options',0);
        static::addInfo('editable',true);
        static::addInfo('instantiable',true);
    }
    
}

class ChildObject extends TestObject
{

    protected static function setupInfos()
    {
        static::addInfo('name','ChildObject');
        static::addInfo('table','childobjects');
        static::addInfo('name_s','Child object',true);
        static::addInfo('name_p','Child objects',true);
        static::addInfo('description','Child object for visual tests', true);
        static::addInfo('options',0);
        static::addInfo('editable',true);
        static::addInfo('instantiable',true);
    }
    
}

class DummyObject extends ORMObject
{
    protected static function setupInfos()
    {
        static::addInfo('name','DummyObject');
        static::addInfo('table','dummyobjects');
        static::addInfo('name_s','Dummy object',true);
        static::addInfo('name_p','Dummy objects',true);
        static::addInfo('description','Dummy object for visual tests', true);
        static::addInfo('options',0);
        static::addInfo('editable',true);
        static::addInfo('instantiable',true);
    }
    
}

class TestResponse extends SunhillResponseBase
{
   
   protected function getResponse()
   {
        return "ABC";    
   }
   
}

class DialogsTest extends SunhillVisualTestCase
{
  
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
            ['TestObject',TestObject::class],
        ];    
  }

  public function testGetClassNameWithObject()
  {
      $this->setupClasses();
      $test = new DialogManager();
      $object = new TestObject();
      $this->assertEquals(TestObject::class,$this->callProtectedMethod($test, 'getClassName',[$object]));
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

  public function testGetObjectKeyfieldSimple()
  {
      Dialogs::addObjectKeyfield(SearchTestA::class,':Achar');
      $object = Objects::load(5);
      $this->assertEquals('ABC',Dialogs::getObjectKeyfield($object));
  }
  
  public function testGetObjectKeyfieldComplex()
  {
      Dialogs::addObjectKeyfield(SearchTestB::class,':Achar :Bchar');
      $object = Objects::load(10);
      $this->assertEquals('GGG ABC',Dialogs::getObjectKeyfield($object));
  }
  
  public function testObjectListHasId()
  {
      $manager = new DialogManager();

      $test = new ObjectList();
      $test->add(3);
      $test->add(5);
      $this->assertTrue($this->callProtectedMethod($manager, 'objectListHasId',[$test,5]));
      $this->assertFalse($this->callProtectedMethod($manager, 'objectListHasId',[$test,4]));
  }
  
  public function testMergeObjectList()
  {
      $manager = new DialogManager();
      
      $list1 = new ObjectList();
      $list1->add(1);
      $list1->add(2);
      
      $list2 = new ObjectList();
      $list2->add(2);
      $list2->add(3);
      
      $merge = $this->callProtectedMethod($manager,'mergeObjectLists',[$list1,$list2]);
      $this->assertEquals(3,$merge->count());
      $this->assertEquals(1,$merge->getID(0));
      $this->assertEquals(2,$merge->getID(1));
      $this->assertEquals(3,$merge->getID(2));
  }
  
  /**
   * @dataProvider searchKeyfieldForClassProvider
   * @param unknown $class
   * @param unknown $search
   * @param unknown $expect
   */ 
  public function testSearchKeyfieldForClass($class,$search,$anywhere,$expect)
  {
      $manager = new DialogManager();
      Classes::flushClasses();
      Classes::registerClass(SearchtestA::class);
      Classes::registerClass(SearchtestB::class);      
      $manager->addObjectKeyfield(SearchTestA::class,':Achar');
      $manager->addObjectKeyfield(SearchTestB::class,':Achar :Bchar');
  
      $result = $this->callProtectedMethod($manager,'searchKeyfieldForClass',[$class,$search,$anywhere]);
      if (empty($expect)) {
          $this->assertEquals(0,$result->count());
      } else {
          foreach ($expect as $id) {
            $this->assertTrue($this->callProtectedMethod($manager,'objectListHasId',[$result,$id]));
          }
      }
  }
  
  public function searchKeyfieldForClassProvider()
  {
      return [
          [SearchTestA::class,'XYZ',false,[8]],          
          [SearchTestA::class,'ABC',false,[5,11]], 
          [SearchTestB::class,'ABC',false,[10,11]],
          [SearchTestA::class,'UQY',false,[]],          
          [SearchTestA::class,'B',true,[5,7,11]],
      ];
  } 
  
  public function testReLimitObjectList()
  {
      $manager = new DialogManager();
      $list1 = new ObjectList();
      $list1->add(1);
      $list1->add(2);
      $list1->add(3);
      $list1->add(4);
      $list1->add(5);
      
      $this->assertEquals(5,$list1->count());
      $newlist = $this->callProtectedMethod($manager,'reLimitObjectlist',[$list1,2]);
      $this->assertEquals(2,$newlist->count());
  }
  
  /**
   * @dataProvider SearchKeyfieldProvider
   * @param unknown $class
   * @param unknown $search
   * @param unknown $anywhere
   * @param unknown $expect
   */
  public function testSearchkeyfield($class,$search,$anywhere,$expect)
  {
      Classes::flushClasses();
      Classes::registerClass(SearchtestA::class);
      Classes::registerClass(SearchtestB::class);
      Dialogs::addObjectKeyfield(SearchTestA::class,':Achar');
      Dialogs::addObjectKeyfield(SearchTestB::class,':Achar :Bchar');
      
      $result = Dialogs::searchKeyfield($class,$search,$anywhere);
      
      $this->assertEquals($expect, $result);
  }
  
  public function SearchKeyfieldProvider()
  {
    return [
        ['searchtestA','XYZ',false,[['keyfield'=>'XYZ','id'=>8]]],
        ['searchtestA','ABC',false,[['keyfield'=>'ABC','id'=>5],['keyfield'=>'ABC BBB','id'=>11]]],
        ['searchtestB','ABC',false,[['keyfield'=>'GGG ABC','id'=>10],['keyfield'=>'ABC BBB','id'=>11]]],
        ['searchtestA','UQY',false,[]],  
        ['searchtestA','B',true,[
            ['keyfield'=>'ABC','id'=>5],
            ['keyfield'=>'BCC','id'=>7],
            ['keyfield'=>'ABC BBB','id'=>11]
        ]],        
    ];      
  }
  
  public function testSearchKeyfieldInClasses()
  {
      Classes::flushClasses();
      Classes::registerClass(SearchtestA::class);
      Classes::registerClass(SearchtestB::class);
      Classes::registerClass(SearchtestD::class);
      Dialogs::addObjectKeyfield(SearchtestA::class,':Achar');
      Dialogs::addObjectKeyfield(SearchTestB::class,':Achar :Bchar');
      Dialogs::addObjectKeyfield(SearchtestD::class,':Dchar');
      
      $result = Dialogs::searchKeyfieldInClasses(['searchtestA','searchtestD'],'ABC');
    
      $this->assertEquals(
          [
              ['keyfield'=>'ABC','id'=>5],
              ['keyfield'=>'ABC BBB','id'=>11],
              ['keyfield'=>'ABC','id'=>16]              
          ],$result);
  }
  
  /**
   * @dataProvider SearchKeyfieldForFieldProvider
   * @param unknown $search
   * @param unknown $anywhere
   * @param unknown $expect
   */
  public function testSearchKeyfieldForField($search,$anywhere,$expect)
  {
      Classes::flushClasses();
      Classes::registerClass(SearchtestA::class);
      Classes::registerClass(SearchtestB::class);
      Classes::registerClass(SearchtestD::class);
      Dialogs::addObjectKeyfield(SearchtestA::class,':Achar');
      Dialogs::addObjectKeyfield(SearchTestB::class,':Achar :Bchar');
      Dialogs::addObjectKeyfield(SearchtestD::class,':Dchar');
  
      $result = Dialogs::searchKeyfieldForField('searchtestD','Dobject',$search,$anywhere);
      $this->assertEquals($expect,$result);
  }
  
  public function SearchKeyfieldForFieldProvider()
  {
    return [
        ['XY',false,[['keyfield'=>'XYZ','id'=>8]]],
        ['ABC',false,[              
            ['keyfield'=>'ABC','id'=>5],
            ['keyfield'=>'ABC BBB','id'=>11],
            ['keyfield'=>'ABC','id'=>16]
        ]],
    ];    
  }
  
}  
