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
        return $response->execAdd(request());
    }
    
    public function edit($id)
    {
        $response = $this->getResponse();
        return $response->edit(request('id'));        
    }
    
    public function execEdit()
    {
        $response = $this->getResponse();
        return $response->execEdit(request('id'), request());        
    }
    
    public function delete()
    {
        $response = $this->getResponse();
        return $response->delete(request('id'));        
    }
    
    public function confirmGroupDelete()
    {
        $response = $this->getResponse();
        return $response->confirmGroupDelete(request('selected'));        
    }
    
    public function execGroupDelete(Request $request)
    {
        $response = $this->getResponse();
        return $response->execGroupDelete(request('selected'));        
    }
    
    public function groupEdit(Request $request)
    {
        $response = $this->getResponse();
        return $response->groupEdit(request('selected'));
    }
    
    public function execGroupEdit(Request $request)
    {
        $response = $this->getResponse();        
        return $response->execGroupEdit(request('selected'),request());
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
