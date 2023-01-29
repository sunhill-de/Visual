<?php

namespace Sunhill\Visual\Response;

class SunhillRedirectResponse extends SunhillResponseBase
{
    protected $target;
  
    public function setTarget(string $target)
    {
      $this->target = $target;
      return $this;
    }
  
    protected function getResponse()
    {
        return redirect($this->target);
    }
  
}  
