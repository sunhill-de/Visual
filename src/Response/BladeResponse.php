<?php

namespace Sunhill\Visual\Response;

class BladeResponse extends ResponseBase
{
    protected $template;
  
    public function setTemplate(string $template)
    {
      $this->template = $template;
      return $this;
    }
  
    protected function getResponse()
    {
        return view($this->template,$this->params);
    }
  
}  
