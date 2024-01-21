<?php

namespace Sunhill\Visual\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Blade;
use Sunhill\Visual\Facades\Users;
use Sunhill\Visual\Response\Users\UserResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function login()
    {
        $response = new UserResponse();        
        return $response->login();
    }
    
    public function execLogin()
    {
        $response = new UserResponse();
        return $response->execLogin();
    }
    
    public function logoff()
    {
        $response = new UserResponse();
        return $response->logoff();
    }
    
}
