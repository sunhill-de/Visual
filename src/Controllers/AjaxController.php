<?php

namespace Sunhill\Visual\Controllers;

use Illuminate\Routing\Controller;

class AjaxController extends Controller
{

  public function searchTags(Request $request,Response $response)
  {
  }
  
  public function searchObjects(Request $request,Response $response)
  {
  }
  
  protected function mergeResult($result1,$result2)
  {
  }
  
  protected function getOutput($result)
  {
        return response()->json($result,200)->header('Content-type', 'application/json');
  }
  
}
