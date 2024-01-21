<?php

namespace Sunhill\Visual\Facades;

use Illuminate\Support\Facades\Facade;

class Users extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'usermanager';
    }
}
