<?php

/**
 * @file LoginResponse
 * Basic class that return a simple login screen
 *
 */
namespace Sunhill\Visual\Response\Users;

use Sunhill\Visual\Modules\SunhillModuleTrait;
use Sunhill\Visual\Response\SunhillRedirectResponse;
use Sunhill\Visual\Facades\Users;

/**
 * Baseclass for responses. Responses are simplified controller actions.
 * @author klaus
 *
 */
class LogoffResponse extends SunhillRedirectResponse
{
    
    protected $target = '/';
    
    protected function prepareResponse()
    {
        parent::prepareResponse();
        Users::login(request('user'),request('password'));
    }
    
}