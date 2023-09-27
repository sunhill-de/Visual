<?php

namespace Sunhill\Visual\Tests\Unit\Managers\DialogManager;

use Sunhill\Visual\Managers\DialogManager;
use Sunhill\Visual\Tests\SunhillVisualTestCase;

class HTMLTest extends SunhillVisualTestCase
{

    /**
     * @dataProvider HTMLProvider
     */
    public function testHTMLResponse(string $route, int $response_code = 200, string $method = 'get', string $expect_to_see = "", string $dont_expect_to_see = "")
    {
        $response = $this->$method($route);
        $response->assertStatus($response_code);
        if (!empty($expect_to_see)) {
            $response->assertSeeText($expect_to_see);
        }
        if (!empty($dont_expect_to_see)) {
            $response->assertDontSee($dont_expect_to_see);
        }
    }
    
    public static function HTMLProvider()
    {
        return [
            ['/ajax/test?search=De',200],       // Search via ajax
            ['/dialog/add',200],                // Add dialog
        ];
    }
    
    public function testSuccessfulAdd()
    {
        $response = $this->post('/dialog/execadd',[
            'teststring'=>'TestString'
        ]);
        $response->assertStatus(200)->assertSee('TestString');
    }
    
    public function testSuccessfulAddAll()
    {
        $response = $this->post('/dialog/execadd',[
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
        ]);
        $response->assertStatus(200)
        ->assertSee('TestString')
        ->assertSee('ABC')
        ->assertSee('<td>4</td>', false);
    }
    
    public function testFailedAddDisplayOldValues()
    {
        $response = $this->post('/dialog/execadd',[
            'testpassword'=>'secret',
            'testdate'=>'2023-09-27',
            'testdatetime'=>'2023-09-27T22:22',
            'testtime'=>'12:34',
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
        ]);
        $response->assertStatus(200)
        ->assertSee('<input', false)
        ->assertSee('value="2023-09-27"', false)
        ->assertSee('value="2023-09-27T22:22"', false)
        ->assertSee('value="12:34"', false)
        ->assertSee('value="#000000"', false)
        ->assertSee('value="10"', false)
        ->assertSee('value="2023-09-27T22:22"', false)
        ->assertSee('value="entry2" selected', false)
        ->assertSee('value="radioentry2" checked', false)
        ->assertSee('This is a text')
        ->assertSee('value="ABC"', false)
        ->assertSee('value="DEF"', false)
        ->assertSee('value="1"', false)
        ->assertSee('value="2"', false)
        ->assertSee('value="Iron Maiden"', false)
        ->assertSee('value="Def Leppard"', false)
        ->assertSee('value="4"', false);
    }
    
}  
