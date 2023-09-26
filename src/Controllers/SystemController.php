<?php

namespace Sunhill\Visual\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Blade;
use Sunhill\Visual\Facades\Dialogs;
use Sunhill\Visual\Facades\SunhillSiteManager;

class SystemController extends Controller
{
    public function css() 
    {
        return SunhillSiteManager::composeCSS();
    }
    
    public function js() 
    {
        return SunhillSiteManager::composeJS();
    }
    
}
