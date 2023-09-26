<?php

namespace Sunhill\Visual\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Blade;
use Sunhill\Visual\Facades\Dialogs;
use Sunhill\Visual\Test\TestDialogResponse;
use Sunhill\Visual\Facades\SunhillSiteManager;

class AjaxController extends Controller
{

    public function ajax(string $topic, string $additional1 = '', string $additional2 = '')
    {
        if ($module = SunhillSiteManager::getAjaxModule($topic)) {
            return $this->getOutput($module->getOutput($additional1, $additional2));        
        }
        return abort(500, 'Unknown ajax module "'.$topic.'"');
    }

    protected function getOutput($result)
    {
        return response()->json($result,200)->header('Content-type', 'application/json');
    }
        
}
