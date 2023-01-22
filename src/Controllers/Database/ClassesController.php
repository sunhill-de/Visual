<?php

namespace Sunhill\Visual\Controllers\Database;

use Illuminate\Routing\Controller;
use Sunhill\Visual\Facades\SiteManager;
use Sunhill\Objects\Objects\Person;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Sunhill\Modules\SunhillModuleTrait;

class ClassesController extends Controller
{

    use SunhillModuleTrait;
    
    public function index()
    {
    }
    
    public function list(Request $request)
    {
    }
    
}
