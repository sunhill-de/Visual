<?php

namespace Sunhill\Visual\Controllers\Database;

use Illuminate\Routing\Controller;
use Sunhill\Visual\Response\SunhillTileViewResponse;
use Sunhill\Visual\Response\Database\Objects\ListObjectsResponse;
use Sunhill\Visual\Response\Database\Objects\ShowObjectResponse;
use Sunhill\Visual\Response\Database\Objects\AddObjectResponse;
use Sunhill\Visual\Response\Database\Classes\ChooseClassResponse;
use Sunhill\Visual\Response\Database\Objects\ExecAddObjectResponse;

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
    
    public function add($class=null)
    {
        if (is_null($class)) {
            $response = new ChooseClassResponse();
            $response->setAction('add');
        } else {
            $response = new AddObjectResponse();
            $response->setClass($class);
        }
        return $response->response();
    }
    
    public function execAdd()
    {
        $response = new ExecAddObjectResponse();
        return $response->response();
    }
    
    public function edit($id)
    {
        
    }
    
    public function execEdit($id)
    {
        
    }
    
    public function delete($id)
    {
        
    }
    
}
