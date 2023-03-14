<?php

namespace Sunhill\Visual\Tests\Unit;

use Sunhill\Visual\Modules\ModuleBase;
use Sunhill\Visual\Response\ResponseBase;
use Sunhill\Visual\Tests\CreatesApplication;
use Sunhill\Basic\Tests\SunhillOrchestraTestCase;
use Illuminate\Http\Request;

class ResponseTestResponse extends ResponseBase
{
    protected function getResponse()
    {
        return "Response".$this->remaining;
    }
    
    
}

class ResponseBaseTest extends SunhillOrchestraTestCase
{
  
  use CreatesApplication;
    

  /**
   * @dataProvider solveRemainingProvider
   * @param unknown $matrix
   * @param unknown $remaining
   * @param unknown $key
   * @param unknown $value
   * @throws \Exception
   */
  public function testSolveRemaining($matrix,$remaining,$key,$value) 
  {
      $test = new ResponseTestResponse();
      $test->setRemaining($remaining);
      try {
        $result = $this->callProtectedMethod($test, 'solveRemaining', [$matrix]);
      } catch (\Exception $e) {
          if ($key == 'except') {
              $this->assertTrue(true);
              return;
          } else {
              throw $e;
          }
      }
      $this->assertEquals($value,$result[$key]);
  }
  
  public function solveRemainingProvider()
  {
      return [
          ['value','1','value',1],
          ['value1/value2','1/2','value1',1],
          ['value1/value2','1/2','value2',2],
          ['value1/value2?','1/2','value2',2],
          ['value1/value2?','1','value2',null],
          ['value1/value2=2','1','value2',2],
          ['value1','1/2','except',null],
          ['value1/value2','1','except',null],
      ];
  }
}  
