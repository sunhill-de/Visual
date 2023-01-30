<?php

namespace Sunhill\Visual\Response\Database\Objects;

use Sunhill\Visual\Response\SunhillBladeResponse;
use Sunhill\ORM\Facades\Objects;
use Sunhill\ORM\Utils\ObjectList;
use Sunhill\ORM\Facades\Classes;
use Sunhill\ORM\Properties\PropertyTags;
use Sunhill\ORM\Properties\PropertyExternalHooks;
use Sunhill\Visual\Facades\Dialogs;

class ShowObjectResponse extends SunhillBladeResponse
{

    protected $template = 'visual::objects.show';
    
    protected $id;

    protected function prepareResponse()
    {
        parent::prepareResponse();
        $this->params['fields'] = $this->getFields($this->id);
        $this->params['tags'] = $this->getTags($this->id);
        $this->params['attributes'] = $this->getAttributes($this->id);
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
                        $datetime = new \DateTime($property->getValue());
                        $entry->value = $datetime->format('d.m.Y');
                        break;
                    case "Time":
                        $datetime = new \DateTime($property->getValue());
                        $entry->value = $datetime->format('H:i:s');
                        break;
                    case "DateTime":
                    case "Timestamp":    
                        $datetime = new \DateTime($property->getValue());
                        $entry->value = $datetime->format('d.m.Y H:i:s');
                        break;
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
            if (is_int($entry)) {
                $entry = Objects::load($entry);
            }
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
  
    public function setID($id)
    {
        $this->id = $id;
        return $this;
    }
    
}  
