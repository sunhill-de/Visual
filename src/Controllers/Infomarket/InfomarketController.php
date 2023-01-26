<?php

namespace Sunhill\Visual\Controllers\Infomarket;

use Illuminate\Routing\Controller;
use Sunhill\Visual\Response\SunhillTileViewResponse;
use Sunhill\Visual\Response\Database\Classes\ListClassesResponse;
use Sunhill\Visual\Response\Database\Classes\ShowClassResponse;

class InfomarketController extends Controller
{
    
    public function index()
    {
        $response = new SunhillTileViewResponse();
        return $response->response();
    }
    
 }
