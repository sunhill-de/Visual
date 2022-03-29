<?php

namespace Sunhill\Visual\Facades;

use Illuminate\Support\Facades\Facade;

class Modules extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'modules';
    }
}
