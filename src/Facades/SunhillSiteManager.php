<?php

namespace Sunhill\Visual\Facades;

use Illuminate\Support\Facades\Facade;

class SunhillSiteManager extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'sunhillsitemanager';
    }
}
