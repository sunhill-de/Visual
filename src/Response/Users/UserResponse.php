<?php

/**
 * @file LoginResponse
 * Basic class that return a simple login screen
 *
 */
namespace Sunhill\Visual\Response\Users;

use Sunhill\Visual\Modules\SunhillModuleTrait;
use Sunhill\Visual\Response\SunhillBladeResponse;
use Sunhill\Visual\Facades\Users;
use Sunhill\Visual\Response\SunhillResponseBase;

/**
 * Baseclass for responses. Responses are simplified controller actions.
 * @author klaus
 *
 */
class UserResponse extends SunhillResponseBase
{
    
    /**
     * Executes a very simple login dialog, it just asks for username and password
     * (no "ups, I forgot my password")
     * 
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function login()
    {
        return view('visual::user.login', array_merge($this->getBasicParams(),
            [
                'users'=>Users::getUserList()
            ])); 
    }
    
    /**
     * Executes the login. If successful, return to the previous page otherwise show error
     * 
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|unknown
     */
    public function execLogin()
    {
        if (Users::login(request('name'),request('password',''))) {
            return redirect(request('returnto','/'));
        } else {
            return $this->wrongPassword();
        }
    }
    
    /**
     * Logs off the current user
     * 
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function logoff()
    {
        Users::logoff();
        return redirect(url()->previous('/'));
    }
    
    /**
     * Shows the login dialog again with a message, that the password was wrong
     * 
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function wrongPassword()
    {
        return view('visual::user.login', array_merge($this->getBasicParams(),
            [
                'users'=>Users::getUserList(),
                'error'=>'Wrong password'
            ]));        
    }
        
}