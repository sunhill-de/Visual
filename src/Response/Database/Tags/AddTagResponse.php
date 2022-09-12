<?php

namespace Sunhill\Visual\Response\Database\Objects;

use Sunhill\Visual\Response\BladeResponse;
use Sunhill\ORM\Facades\Tags;

class AddTagResponse extends BladeResponse
{

    protected $template = 'visual::tags.edit';
        
    protected function prepareResponse()
    {
        $this->params['title'] = __('Add tag');
        $this->params['action'] = $this->getPrefix().'/Tags/execadd';
        $this->params['name'] = '';
        $this->params['parent_name'] = '';
        $this->params['parent_id'] = '';
        $this->params['leafable'] = true;
    }
    
}  
