<?php

namespace Sunhill\Visual\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Blade;
use Sunhill\Visual\Facades\Dialogs;
use Sunhill\Visual\Test\TestDialogResponse;
use Sunhill\Visual\Facades\SunhillSiteManager;
use Illuminate\Http\Request;

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
    
    public function list()
    {
        $response = $this->getResponse();
        return $response->list(request('page',0), request('order','default'), request('filter','none'));
    }
    
    public function filter()
    {
        $response = $this->getResponse();
        return $response->filter(request('order','default'));        
    }
    
    public function show()
    {
        $response = $this->getResponse();
        return $response->show(request('id'));
    }
}
