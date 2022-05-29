<?php

namespace Sunhill\Visual\Facades;

use Illuminate\Support\Facades\Facade;

class Dialogs extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'dialogmanager';
    }
}
