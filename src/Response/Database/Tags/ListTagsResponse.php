<?php

namespace Sunhill\Visual\Response\Database\Objects;

use Sunhill\Visual\Response\BladeResponse;
use Sunhill\ORM\Facades\Tags;

define("ENTRIES_PER_PAGE", 25);

class ListTagsResponse extends BladeResponse
{

    protected $template = 'visual::tags.list';
    
    protected function getTagList(int $page, string $oder)
    {
    }
    
    protected function prepareResponse()
    {
    }
    
}  
