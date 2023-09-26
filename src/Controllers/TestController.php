<?php

namespace Sunhill\Visual\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Blade;
use Sunhill\Visual\Facades\Dialogs;
use Sunhill\Visual\Test\TestDialogResponse;

class TestController extends Controller
{
    public function add()
    {
        $response = new TestDialogResponse();
        $response->setMode('add');
        return $response->response();        
    }
    
    public function execadd()
    {
        $response = new TestDialogResponse();
        $response->setMode('execadd');
        return $response->response();        
    }
    
    public function edit()
    {
        
    }
    
    public function execedit()
    {
        
    }
}
