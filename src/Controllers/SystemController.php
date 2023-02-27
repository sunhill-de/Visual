<?php

namespace Sunhill\Visual\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Blade;
use Sunhill\Visual\Facades\Dialogs;

class SystemController extends Controller
{
    public function css() 
    {
        return Dialogs::composeCSS();
    }
    
    public function js() 
    {
        return Dialogs::composeJS();
    }
    
}
