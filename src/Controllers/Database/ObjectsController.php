<?php

namespace Sunhill\Visual\Controllers\Database;

use Illuminate\Routing\Controller;
use Sunhill\Visual\Response\SunhillTileViewResponse;
use Sunhill\Visual\Response\Database\Objects\ListObjectsResponse;
use Sunhill\Visual\Response\Database\Objects\ShowObjectResponse;
use Sunhill\Visual\Response\Database\Objects\AddObjectResponse;
use Sunhill\Visual\Response\Database\Objects\EditObjectResponse;
use Sunhill\Visual\Response\Database\Classes\ChooseClassResponse;
use Sunhill\Visual\Response\Database\Objects\ExecAddObjectResponse;
use Sunhill\Visual\Response\Database\Objects\ExecEditObjectResponse;
use Sunhill\Visual\Response\Database\Objects\DeleteObjectResponse;

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
        $response = new ShowObjectResponse();
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
        $response = new EditObjectResponse();
        $response->setID($id);
        return $response->response();
    }
    
    public function execEdit($id)
    {
        $response = new ExecEditObjectResponse();
        $response->setID($id);
        return $response->response();
    }
    
    public function delete($id)
    {
        $response = new DeleteObjectResponse();
        $response->setID($id);
        return $response->response();
    }
    
}
