<?php

/**
 * @file SunhillListResponse
 * Basic class that return blade templates
 *
 */
namespace Sunhill\Visual\Test;

use Sunhill\Visual\Response\Dialog\SunhillDialogResponse;
use Sunhill\Visual\Response\Dialog\DialogDescriptor;

class TestDialogResponse extends SunhillDialogResponse
{

    protected $route_base = 'test';
    
    protected $route_parameters = [];
                
    protected function defineDialog(DialogDescriptor $descriptor)
    {
        $descriptor->string()->label('Test string input')->name('teststring')->required();
        $descriptor->password()->label('Test password')->name('testpassword');
        $descriptor->date()->label('Test date')->name('testdate');
        $descriptor->datetime()->label('Test datetime')->name('testdatetime');
        $descriptor->time()->label('Test time')->name('testtime');
        $descriptor->color()->label('Test color')->name('testcolor');
        $descriptor->number()->label('Test number')->name('testnumber');
        $descriptor->select()->label('Test select')->name('testselect')->entries([
            'Entry 1'=>'entry1','Entry 2'=>'entry2','Entry 3'=>'entry3'
        ]);
        $descriptor->radio()->label('Test radio')->name('testradio')->entries([
            'Radio-Entry 1'=>'radioentry1','Radio-Entry 2'=>'radioentry2','Radio-Entry 3'=>'radioentry3'
        ])->class('radio');
        $descriptor->checkbox()->label('Test checkbox')->name('testcheckbox');
        $descriptor->text()->label('Test text')->name('testtext');
        $descriptor->list()->label('Test list')->name('testlist')->element('string');
        $descriptor->list()->label('Test lookup list')->name('testlookuplist')->element('string')->lookup('test');
        $descriptor->inputLookup()->label('Test lookup input')->name('testlookupinput')->lookup('test');
    }
    
    protected function execAdd($parameters)
    {
        $this->setTemplate('visual::test.show');
        $this->params = array_merge($this->params, $parameters);
    }
    
    protected function getEditValues()
    {
        return [
            'teststring'=>'This is a TestString',
            'testpassword'=>'secret',
            'testdate'=>'2023-09-27',
            'testdatetime'=>'2023-09-27T22:22',
            'testcolor'=>'#000000',
            'testnumber'=>10,
            'testselect'=>'entry2',
            'testradio'=>'radioentry2',
            'testcheckbox'=>'ON',
            'testtext'=>'This is a text',
            'testlist'=>['ABC','DEF'],
            'name_testlist'=>['ABC','DEF'],
            'testlookuplist'=>[1,2],
            'name_testlookuplist'=>['Iron Maiden','Judas Priest'],
            'value_testlookupinput'=>4,
            'input_testlookupinput'=>'Def Leppard'            
        ];
    }
    
    protected function execEdit($parameters)
    {
        
    }
    
}
