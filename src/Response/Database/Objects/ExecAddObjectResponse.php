<?php

namespace Sunhill\Visual\Response\Database\Objects;

use Illuminate\Http\Request;

use Sunhill\Visual\Response\RedirectResponse;
use Sunhill\ORM\Facades\Objects;
use Sunhill\ORM\Utils\ObjectList;
use Sunhill\ORM\Facades\Classes;

class ExecAddObjectResponse extends RedirectResponse
{

    protected $target = '/';
    
    protected function prepareResponse()
    {
        $object = Classes::createObject($this->request->input('_class'));       
        foreach ($this->request->all() as $param => $value) {
            if ($param[0] != '_') {
                // Ignore helping dialog elements
                $property = $object->getPropertyObject($param);
                if (!is_null($property)) {
                    switch ($property->getType()) {
                        case 'Varchar':
                            $object->$param = $value;
                            break;
                    }
                }
            }
        }
        $object->commit();
    }
    
}  
