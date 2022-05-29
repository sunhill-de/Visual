<?php

namespace Sunhill\Visual\Response;

use Illuminate\Http\Request;

abstract class ResponseBase
{
    protected $request;
  
    protected $params;
  
    protected $remaining;
    
    protected $parent;
    
    public function setParent($parent)
    {
        $this->parent = $parent;
        return $this;
    }
    
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
  
    public function setRemaining(string $remaining)
    {
        $this->remaining = $remaining;
        return $this;
    }
    
    abstract protected function getResponse();
  
    protected function prepareResponse()
    {
    }
    
    public function response()
    {
        $this->prepareResponse();
        return $this->getResponse();
    }
    
}  
