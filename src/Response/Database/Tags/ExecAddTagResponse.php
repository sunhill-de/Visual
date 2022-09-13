<?php

namespace Sunhill\Visual\Response\Database\Tags;

use Illuminate\Http\Request;

use Sunhill\ORM\Objects\Tag;

class ExecAddTagResponse extends TagResponseBase
{
    
    protected function getWorkingTag()
    {
        $tag = new Tag();
        return $tag;
    }
    
    protected $target = '/';
    
}  
    
