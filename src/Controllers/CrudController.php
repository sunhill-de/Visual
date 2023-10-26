<?php

namespace Sunhill\Visual\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Blade;
use Sunhill\Visual\Facades\Dialogs;
use Sunhill\Visual\Test\TestDialogResponse;
use Sunhill\Visual\Facades\SunhillSiteManager;
use Illuminate\Http\Request;

class CrudController extends SemiCrudController
{

    public function add()
    {
        $response = $this->getResponse();
        return $response->add();
    }
    
    public function execAdd(Request $request)
    {
        $response = $this->getResponse();
        return $response->execAdd($request);
    }
    
    public function edit($id)
    {
        $response = $this->getResponse();
        return $response->edit($id);        
    }
    
    public function execEdit($id, Request $request)
    {
        $response = $this->getResponse();
        return $response->execEdit($id, $request);        
    }
    
    public function delete($id)
    {
        $response = $this->getResponse();
        return $response->delete($id);        
    }
    
    public function confirmGroupDelete(Request $request)
    {
        $response = $this->getResponse();
        return $response->confirmGroupDelete($request->input('selected'));        
    }
    
    public function execGroupDelete(Request $request)
    {
        $response = $this->getResponse();
        return $response->execGroupDelete($request->input('selected'));        
    }
    
    public function groupEdit(Request $request)
    {
        $response = $this->getResponse();
        return $response->groupEdit($request->input('selected'));
    }
    
    public function execGroupEdit(Request $request)
    {
        $response = $this->getResponse();        
        return $response->execGroupEdit($request->input('selected'),$request);
    }
    
    /**
     * Returns true when the connected response provides the group action 'delete'
     * @return bool
     */
    public static function providesGroupDelete(): bool
    {
        return static::$crud_response::providesGroupDelete();
    }
    
    /**
     * Returns true when the connected response provides the group action 'edit'
     * @return bool
     */
    public static function providesGroupEdit(): bool
    {
        return static::$crud_response::providesGroupEdit();
    }
    
}
