<?php

namespace Sunhill\Visual\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Blade;
use Sunhill\Visual\Facades\Dialogs;
use Sunhill\Visual\Test\TestDialogResponse;
use Sunhill\Visual\Facades\SunhillSiteManager;

class SemiCrudController extends Controller
{

    protected static $crud_response = '';
    
    protected function getResponse()
    {
        $response = new static::$crud_response();
        $this->addAdditionalParameters($response);
        return $response;
    }
    
    protected function addAdditionalParameters($response)
    {
        
    }
    
    public function index()
    {
        $response = $this->getResponse();
        return $response->index();
    }
    
    public function list(int $page = 0, string $order = 'default', string $filter = 'none')
    {
        $response = $this->getResponse();
        return $response->list($page, $order, $filter);
    }
    
    public function filter(string $order = 'default')
    {
        $response = $this->getResponse();
        return $response->filter($order);        
    }
    
    public function show($id)
    {
        $response = $this->getResponse();
        return $response->show($id);
    }
}
