<?php

namespace Sunhill\Visual\Controllers;

use Illuminate\Routing\Controller;
use Sunhill\Visual\Facades\Dialogs;

use Illuminate\Http\Request;
use Illuminate\Http\Response;


define('ANYWHERE', true);
define('LIMIT', 10);

class AjaxController extends Controller
{

  public function searchTags(string $class="", Request $request,Response $response)
  {
  }
  
  protected function mergeResult($result1,$result2)
  {
  }
  
  protected function getOutput($result)
  {
        return response()->json($result,200)->header('Content-type', 'application/json');
  }
  
  public function getArrayOfStringSuggestion(string $class, string $field)
  {
      
  }
  
  public function searchObjects(string $class, string $field, Request $request)
  {     
      $search = $request->input('search');
      $result = Dialogs::searchKeyfieldForField($class,$field,$search,ANYWHERE,LIMIT);
      $newresult = [];
      foreach ($result as $entry) {
          $newentry = new \StdClass();
          $newentry->label = $entry['keyfield'];
          $newentry->id = $entry['id'];
          $newresult[] = $newentry;
      }
      return $this->getOutput($newresult);      
  }
}
