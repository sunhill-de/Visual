<?php

use Sunhill\Visual\Tests\SunhillVisualTestCase;
use Sunhill\Visual\Response\SunhillResponseBase;
use Sunhill\Visual\Response\SunhillUserException;
use Sunhill\Visual\Modules\SunhillModuleTrait;

/**
 * SunhillResponseBase test case.
 */
class DialogTest extends SunhillVisualTestCase
{

    /**
     * @dataProvider SetterProvider
     */
    public function testSetter($class, $method, $value)
    {
        $test = new $class();
        $test->$method($value);
        $method = 'get'.ucfirst($method);
        $this->assertEquals($value, $test->$method());
    }
    
    public static function SetterProvider()
    {
        return [
            ['\\Sunhill\\Visual\\Response\\Dialog\\DialogEntryText', 'label', 'testlabel'],
            ['\\Sunhill\\Visual\\Response\\Dialog\\DialogEntryText', 'name', 'testname'],
            ['\\Sunhill\\Visual\\Response\\Dialog\\DialogEntryText', 'required', true],
        ];
    }
    
    public function testDefaultDialogName()
    {
        $test = new Sunhill\Visual\Response\Crud\DialogEntryText();
        $test->name('test');
        $this->assertEquals('test',$test->getDialogName());
    }
    
    public function testEntryInputGetHTML()
    {
        $test = new Sunhill\Visual\Response\Crud\DialogEntryInput();
        $test->setElementName('text')->name('test');
        
        $this->assertEquals('<input type="text" name="test">', $test->getHTMLCode());
        
        $test->value('value');
        $this->assertEquals('<input type="text" name="test" value="value">', $test->getHTMLCode());
        
        $test->class('someclass');
        $this->assertEquals('<input type="text" name="test" class="someclass" value="value">', $test->getHTMLCode());
    }
}

