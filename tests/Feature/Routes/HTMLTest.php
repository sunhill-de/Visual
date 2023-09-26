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
            ['/ajax/test?search=De',200],       // Search Tags
        ];
    }
    
}  
