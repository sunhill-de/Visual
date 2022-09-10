<?php

namespace Sunhill\Visual\Controllers;

use Illuminate\Routing\Controller;
use Sunhill\Visual\Facades\Dialogs;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\DB;

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
  
  public function getArrayOfStringSuggestion(string $class, string $field, Request $request)
  {
      $search = $request->input('search');
      $query = DB::table('stringobjectassigns')
       ->join('objects','stringobjectassigns.container_id','=','objects.id')
       ->select('element_id')
       ->where('stringobjectassigns.field',$field)
       ->where('element_id','like','%'.$search.'%')
       ->groupBy('element_id')
       ->get();
       $newresult = [];
       foreach ($query as $entry) {
           $newentry = new \StdClass();
           $newentry->label = $entry->element_id;
           $newentry->id = $entry->element_id;
           $newresult[] = $newentry;
       }
       return $this->getOutput($newresult);
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
