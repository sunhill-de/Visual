<?php

namespace Sunhill\Visual\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Blade;
use Sunhill\Visual\Facades\Dialogs;
use Sunhill\Visual\Test\TestDialogResponse;
use Sunhill\Visual\Facades\SunhillSiteManager;

class CrudController extends Controller
{

    protected static $crud_response = '';
    
    public function index()
    {
        $response = new static::$crud_response();
        return $response->index();
    }
    
    public function list(int $page = 0, string $order = 'id', string $filter = 'none')
    {
        $response = new static::$crud_response();
        return $response->list($page, $order, $filter);
    }
    
    public function filter(string $order = 'id')
    {
        $response = new static::$crud_response();
        return $response->filter($order);        
    }
}
