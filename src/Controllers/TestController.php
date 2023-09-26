<?php

namespace Sunhill\Visual\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Blade;
use Sunhill\Visual\Facades\Dialogs;
use Sunhill\Visual\Test\TestDialogResponse;

class TestController extends Controller
{
    public function dialog()
    {
        $response = new TestDialogResponse();
        return $response->response();        
    }
    
    public function execute()
    {
        
    }
}
