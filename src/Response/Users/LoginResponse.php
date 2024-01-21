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

/**
 * Baseclass for responses. Responses are simplified controller actions.
 * @author klaus
 *
 */
class LoginResponse extends SunhillBladeResponse
{
    
    protected $template = 'visual::user.login';
    
    protected function prepareResponse()
    {
        parent::prepareResponse();
        $this->params['users'] = Users::getUserList();
    }
    
}