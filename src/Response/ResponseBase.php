<?php

namespace Sunhill\Visual\Response;

use Illuminate\Http\Request;

abstract class ResponseBase
{
    protected $request;
  
    protected $params;
  
    public function setRequest(Request $request)
    {
      $this->request = $request;
      return $this;
    }  
  
    public function setParams(array $params)
    {
      $this->params = $params;
      return $this;
    }
  
    abstract protected function getResponse();
  
}  
