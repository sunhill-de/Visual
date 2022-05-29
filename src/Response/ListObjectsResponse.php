<?php

namespace Sunhill\Visual\Response;

class ListObjectsResponse extends ResponseBase
{

    protected function getResponse()
    {
        return view($this->template,$this->params);
    }
  
}  
