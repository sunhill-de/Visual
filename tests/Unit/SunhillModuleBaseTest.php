<?php

namespace Sunhill\Visual\Tests\Unit;

use Sunhill\Visual\Modules\SunhillModuleBase;
use Sunhill\Basic\Tests\SunhillNoAppTestCase;

class SunhillModuleBaseTest extends SunhillNoAppTestCase
{
  
    public function testGetterSetter()
    {
        $parent = new SunhillModuleBase();
        $test = new SunhillModuleBase();
        $test->setName('test') 
            ->setDescription('description')
            ->setParent($parent)
            ->setDisplayName('Display')
            ->setVisible(true)
            ->setActive(true);
        $this->assertEquals('test',$test->getName());
        $this->assertEquals('Display',$test->getDisplayName());
        $this->assertEquals('description',$test->getDescription());
        $this->assertEquals($parent,$test->getParent());
        $this->assertTrue($test->getVisible());
        $this->assertTrue($test->getActive());
    }
    
    public function testAssertParentNotThis()
    {
        $this->expectException(\Exception::class);
        $test = new SunhillModuleBase();
        $test->setParent($test);
    }
    
    public function testAddSubmoduleEntry()
    {
        $submodule = new SunhillModuleBase();
        $submodule->setName('test');
        $test = new SunhillModuleBase();
        
        $this->callProtectedMethod($test,'addSubmoduleEntry',[$submodule]);
        
        $this->assertEquals($test,$submodule->getParent());
        $this->assertEquals($submodule,$this->getProtectedProperty($test,'submodules')['test']);
    }
    
    public function testAddSubmodule()
    {
        $submodule = new SunhillModuleBase();
        $submodule->setName('test');
        $test = new SunhillModuleBase();
    
        $test->addSubmodule($submodule,function($entry) { $entry->setDescription('success'); });

        $this->assertEquals($test,$submodule->getParent());
        $this->assertEquals($submodule,$this->getProtectedProperty($test,'submodules')['test']);
        $this->assertEquals('success',$submodule->getDescription());
    }
    
    public function testAddDefaultSubmodule()
    {
        $test = new SunhillModuleBase();
        $module = $test->addDefaultSubmodule('tEsT');
        
        $this->assertEquals($test, $module->getParent());
        $this->assertEquals('tEsT', $module->getName());
    }
    
    public function testGetParentRoute()
    {
        $submodule = new SunhillModuleBase();
        $submodule->setName('sub');
        
        $test = new SunhillModuleBase();
        $test->setName('main');
        $test->addSubmodule($submodule);
        
        $this->assertEquals('',$this->callProtectedMethod($test,'getParentRoute'));
        $this->assertEquals('/',$this->callProtectedMethod($submodule,'getParentRoute'));
    }
    
    public function testGetRouteName()
    {
        $test = new SunhillModuleBase();
        $test->setName('main');
        $this->assertEquals('',$this->callProtectedMethod($test, 'getRouteName'));

        $test->setName('index');
        $this->assertEquals('',$this->callProtectedMethod($test, 'getRouteName'));
    }
    
    public function testGetRoute()
    {
        $submodule = new SunhillModuleBase();
        $submodule->setName('sub');
        
        $test = new SunhillModuleBase();
        $test->setName('main');
        $test->addSubmodule($submodule);
        
        $this->assertEquals('/',$test->getRoute());
        $this->assertEquals('/sub',$submodule->getRoute());
    }
    
    public function testGetStdClass()
    {
        $generator = new SunhillModuleBase();
        $test = $this->callProtectedMethod($generator,'getStdClass',[['a'=>'1','b'=>2]]);
        $this->assertEquals(1, $test->a);
        $this->assertEquals(2, $test->b);
    }
    
    /**
     * @dataProvider hasActiveModuleProvider
     * @param unknown $module
     * @param unknown $remain
     * @param unknown $expect
     */
    public function testHasActiveModule($module,$remain,$expect)
    {
        $subsubmodule = new SunhillModuleBase();
        $subsubmodule->setName('subsub');
        
        $submodule = new SunhillModuleBase();
        $submodule->setName('sub');
        $submodule->addSubModule($subsubmodule);
        
        $test = new SunhillModuleBase();
        $test->setName('main');
        $test->addSubmodule($submodule);
    
        switch ($expect) {
            case 'subsub':
               $expect = $subsubmodule; break;
            case 'sub':
               $expect = $submodule; break;
            case 'main':
               $expect = $test; break; 
        }
        
        $this->assertEquals($expect,$this->callProtectedMethod($test,'hasActiveModule',[$module,$remain]));
    }
    
    public function hasActiveModuleProvider()
    {
        return [
            ['','','main'],
            ['sub','','sub'],
            ['sub','subsub','subsub'],
            ['sub','dontexists',null],
            
        ];    
    }
    
    /**
     * @dataProvider cleanPathProvider
     * @param unknown $path
     * @param unknown $expect
     */
    public function testCleanPath($path, $expect)
    {
        $test = new SunhillModuleBase();
        $this->assertEquals($expect,$this->callProtectedMethod($test,'cleanPath',[$path]));
    }

    public function cleanPathProvider()
    {
        return [
            ['/test','test'],
            ['test/sub','test/sub'],
            ['test//sub','test/sub'],
            ['test','test'],
            ['/test/this/','test/this']
        ];    
    }
    
    
    /**
     * @dataProvider getActiveModuleProvider
     * @param unknown $path
     * @param unknown $expect
     */
    public function testGetActiveModule($path, $expect)
    {
        $subsubmodule = new SunhillModuleBase();
        $subsubmodule->setName('subsub');
        
        $submodule = new SunhillModuleBase();
        $submodule->setName('sub');
        $submodule->addSubModule($subsubmodule);
        
        $test = new SunhillModuleBase();
        $test->setName('main');
        $test->addSubmodule($submodule);
        
        switch ($expect) {
            case 'subsub':
                $expect = $subsubmodule; break;
            case 'sub':
                $expect = $submodule; break;
            case 'main':
                $expect = $test; break;
        }
        $this->assertEquals($expect, $test->getActiveModule($path));
    }
    
    public function getActiveModuleProvider()
    {
        return [
            ['','main'],
            ['/','main'],
            ['/sub','sub'],
            ['/sub/','sub'],
            ['/sub/subsub','subsub'],
            ['/sub/unknown',null]
        ];
    }
    
    public function testAddBreadcrumb()
    {
        $subsubmodule = new SunhillModuleBase();
        $subsubmodule->setName('subsub');
        $subsubmodule->setDisplayName('SubSub');
        
        $submodule = new SunhillModuleBase();
        $submodule->setName('sub');
        $submodule->setDisplayName('Sub');
        $submodule->addSubModule($subsubmodule);
        
        $test = new SunhillModuleBase();
        $test->setName('main');
        $test->setDisplayName('Main');
        $test->addSubmodule($submodule);
    
        $result = [];
        $this->callProtectedMethod($subsubmodule, 'addBreadcrumb', [&$result]);
        
        $this->assertEquals('/',$result[0]->link);
        $this->assertEquals('Main',$result[0]->name);
        $this->assertEquals('/sub',$result[1]->link);
        $this->assertEquals('Sub',$result[1]->name);
        $this->assertEquals('/sub/subsub',$result[2]->link);
        $this->assertEquals('SubSub',$result[2]->name);
    }
    
    protected function addBreadcrumb(array &$breadcrumbs)
    {
        if (!is_null($this->getParent())) {
            $this->getParent()->addBreadcrumb($breadcrumbs);
        }
        $breadcrumbs[] = $this->getStdClass(['name'=>$this->getDisplayName(),'link'=>'/']);
    }
    
    public function testAddBreadcrumbs()
    {
        $subsubmodule = new SunhillModuleBase();
        $subsubmodule->setName('subsub');
        $subsubmodule->setDisplayName('SubSub');
        
        $submodule = new SunhillModuleBase();
        $submodule->setName('sub');
        $submodule->setDisplayName('Sub');
        $submodule->addSubModule($subsubmodule);
        
        $test = new SunhillModuleBase();
        $test->setName('main');
        $test->setDisplayName('Main');
        $test->addSubmodule($submodule);
        
        $result = $subsubmodule->getBreadcrumbs();
        
        $this->assertEquals('/',$result[0]->link);
        $this->assertEquals('Main',$result[0]->name);
        $this->assertEquals('/sub',$result[1]->link);
        $this->assertEquals('Sub',$result[1]->name);
        $this->assertEquals('/sub/subsub',$result[2]->link);
        $this->assertEquals('SubSub',$result[2]->name);
    }
    
}  
