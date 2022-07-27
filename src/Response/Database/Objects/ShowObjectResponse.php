<?php

namespace Sunhill\Visual\Response\Database\Objects;

use Sunhill\Visual\Response\BladeResponse;
use Sunhill\ORM\Facades\Objects;
use Sunhill\ORM\Utils\ObjectList;
use Sunhill\ORM\Facades\Classes;
use Sunhill\ORM\Properties\PropertyTags;
use Sunhill\ORM\Properties\PropertyExternalHooks;
use Sunhill\Visual\Facades\Dialogs;

class ShowObjectResponse extends BladeResponse
{

    protected $template = 'visual::objects.show';
    
    protected function prepareResponse()
    {
        $result = $this->solveRemaining('id');
        $this->params['id'] = $result['id'];
        $this->params['fields'] = $this->getFields($this->params['id']);
        $this->params['tags'] = $this->getTags($this->params['id']);
        $this->params['attributes'] = $this->getAttributes($this->params['id']);
    }
    
    protected function getFields(int $id)
    {
        $result = [];
        $object = Objects::load($id);
        $properties = $object->getProperties()->get();
        foreach ($properties as $property) {
          if (!is_a($property,PropertyTags::class) &&
              !is_a($property,PropertyExternalHooks::class)) {
                $entry = new \StdClass();
                $name = $property->getName();
                $entry->name = __($name);
                $entry->description = __($property->get_description());
                $entry->class = $property->getClass();
                $entry->type = __($property->getType());
                switch ($property->getType()) {
                    case 'ArrayOfStrings':
                        $entry->value = $this->getArrayOfString($object,$name);
                        break;
                    case 'ArrayOfObjects':
                        $entry->value = $this->getArrayOfObjects($object,$name);
                        break;
                    case 'Object':
                        $entry->value = Dialogs::getObjectKeyfield($object->$name);
                        break;
                    case 'Enum':
                        $entry->value = __($property->getValue());
                        break;
                    case "Date":
                        $datetime = new DateTime($property->getValue);
                    default:
                        $entry->value = $property->getValue();
                }
                $entry->displayable = $property->get_displayable();
                $entry->groupeditable = $property->get_groupeditable();
                $entry->editable = $property->get_editable();
                $result[] = $entry;
              }
        }
        return $result;
    }
    
    protected function getArrayOfString($object,$name)
    {
        $value = $object->$name;
        if ($object->$name->empty()) {
            return '('.__('empty').')';
        }
        $result = '';
        $first = true;
        foreach ($object->$name as $entry) {
            $result .= ($first?'':',').$entry;
            $first = false;
        }
        return $result;
    }
    
    protected function getArrayOfObjects($object,$name)
    {
        $value = $object->$name;
        if ($object->$name->empty()) {
            return '('.__('empty').')';
        }
        $result = '';
        $first = true;
        foreach ($object->$name as $entry) {
            $result .= ($first?'':',').Dialogs::getObjectKeyfield($entry);
            $first = false;
        }
        return $result;
    }
    
    protected function getTags(int $id)
    {
        $result = [];
        return $result;
    }
    
    protected function getAttributes(int $id)
    {
        $result = [];
        return $result;        
    }
    
}  
