<?php

namespace Sunhill\Visual\Tests\Unit\Managers\DialogManager;

use Sunhill\Visual\Managers\DialogManager;
use Sunhill\Visual\Tests\SunhillVisualTestCase;

class DialogManagerResourceTest extends SunhillVisualTestCase
{

    public function testaddCSSResources()
    {
        $test = new DialogManager();
        $test->addCSSResource('test');
        $this->assertEquals('test',$this->getProtectedProperty($test,'css_resources')[0]);
    }
    
    public function testaddJSResources()
    {
        $test = new DialogManager();
        $test->addJSResource('test');
        $this->assertEquals('test',$this->getProtectedProperty($test,'js_resources')[0]);
    }
    
    public function testGetFiles_CSS()
    {
        $test = new DialogManager();
        $test->addCSSResource(dirname(__FILE__).'/../../../Files');
        $this->assertEquals(["A","B"],$this->callProtectedMethod($test,'getFiles',['css']));
    }
    
    public function testGetFiles_JS()
    {
        $test = new DialogManager();
        $test->addJSResource(dirname(__FILE__).'/../../../Files');
        $this->assertEquals(["A","B"],$this->callProtectedMethod($test,'getFiles',['js']));
    }
    
    public function testComposeCSS()
    {
        $test = new DialogManager();
        $test->addCSSResource(dirname(__FILE__).'/../../../Files');
        $this->assertEquals("A\nB\n",$test->composeCSS()->getContent());
    }
    
    public function testComposeJS()
    {
        $test = new DialogManager();
        $test->addJSResource(dirname(__FILE__).'/../../../Files');
        $this->assertEquals("A\nB\n",$test->composeJS()->getContent());
    }
    
}  
