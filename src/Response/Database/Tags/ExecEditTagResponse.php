<?php

namespace Sunhill\Visual\Response\Database\Objects;

use Illuminate\Http\Request;

use Sunhill\Visual\Response\RedirectResponse;
use Sunhill\ORM\Facades\Classes;

class ExecEditTagResponse extends TagResponseBase
{
    
    protected $target = '/';
   
    protected function getWorkingTag()
    {
        $id = $this->solveRemaining('id');
        
        $tag = Tags::load($id);
        $this->target = $this->getPrefix().'/Tags/show/'.$id;
        
        return $tag;
    }

}  
    
