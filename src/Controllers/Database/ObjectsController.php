<?php

namespace Sunhill\Visual\Controllers\Database;

use Illuminate\Routing\Controller;
use Sunhill\Visual\Response\SunhillTileViewResponse;
use Sunhill\Visual\Response\Database\Classes\ListClassesResponse;
use Sunhill\Visual\Response\Database\Classes\ShowClassResponse;

class ObjectsController extends Controller
{
    
    public function index()
    {
        $response = new SunhillTileViewResponse();
        return $response->response();
    }
    
    public function list($page=0)
    {
        $response = new ListObjectsResponse();
        $response->setdelta($page);
        return $response->response();
    }
    
    public function show($id)
    {
        $response = new ShowObjectsResponse();
        $response->setID($id);
        return $response->response();
    }
}
