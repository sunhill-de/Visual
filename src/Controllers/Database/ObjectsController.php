<?php

namespace Sunhill\Visual\Controllers\Database;

use Illuminate\Routing\Controller;
use Sunhill\Visual\Response\SunhillTileViewResponse;
use Sunhill\Visual\Response\Database\Objects\ListObjectsResponse;
use Sunhill\Visual\Response\Database\Objects\ShowObjectResponse;

class ObjectsController extends Controller
{
    
    public function index()
    {
        $response = new SunhillTileViewResponse();
        return $response->response();
    }
    
    public function list($key='Object',$page=0)
    {
        $response = new ListObjectsResponse();
        $response->setDelta($page);
        $response->setKey($key);
        return $response->response();
    }
    
    public function show($id)
    {
        $response = new ShowObjectsResponse();
        $response->setID($id);
        return $response->response();
    }
}
