<?php

namespace Sunhill\Visual\Response;

use Illuminate\Http\Request;

abstract class ResponseBase
{
    protected $request;
  
    protected $params;
  
    protected $remaining;
    
    protected $parent;
    
    protected $description;
    
    public function setDescription(string $description)
    {
        $this->description = $description;
        return $this;
    }
    
    public function getDescription()
    {
        return $this->description;
    }
    
    protected function solveRemaining(string $matrix): array
    {
        $result = [];
        
        $matrix_parts = explode('/',$matrix);
        if (!empty($this->remaining)) {
            $remaining_parts = explode('/',$this->remaining);
        } else {
            $remaining_parts = [];
        }
        
        if (count($remaining_parts) > count($matrix_parts)) {
            throw new \Exception(__("Too many parameters given."));
        }
        $i = 0;
        foreach ($matrix_parts as $part) {
            if (strpos($part,'?')) {
                $part = substr($part,0,-1);
                if (isset($remaining_parts[$i])) {
                    $result[$part] = $remaining_parts[$i];
                } else {
                    $result[$part] = null;
                }
            } else if (strpos($part,'=')) {
                list($name,$default) = explode('=',$part);
                if (isset($remaining_parts[$i])) {
                    $result[$name] = $remaining_parts[$i];
                } else {
                    $result[$name] = $default;
                }
            } else {
                if (isset($remaining_parts[$i])) {
                    $result[$part] = $remaining_parts[$i];
                } else {
                    throw new \Exception(__("Expected parameter ':part' not given.",['part'=>$part]));
                }
            }
            $i++;
        }
        return $result;
    }
    
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
