<?php

namespace Sunhill\Visual\Managers;

class DialogManager
{
    
    /**
     * Stores 
     */
    protected $storage;
    
    protected $list_fields;
    
    private $allowed_actions = ['add','edit','groupedit','list','show'];
    
    private function initManager()
    {
        $this->storage = [
            'list'=>[],
            'add'=>[],
            'show'=>[],
            'edit'=>[],
            'groupedit'=>[],
        ];
        $this->list_fields = [
            ORMObject::class=>['UUID']
        ];
        $this->addResponse('list', ORMObject::class, ListObjectsResponse::class);
    }
    
    public function __construct()
    {
        $this->initManager();
    }
    
    /**
     * Depending on whats passed as parameter return the php class name
     */
    protected function getClassName($item)
    {
        if (is_string($item)) {
            // Could be already the internal class name or a php class
        } else if (is_a($item,ORMObject::class)) {
        
        } else if (is_int($item)) {
            // We interpret the item as the object ID
        }    
    }
    
    /**
     * Adds a list of field that should be displayed when objects of the given class are listed
     * @param $class int|string|ORMObject any reference to a class
     * @param $fields array: a list of strings that define the fields for the list
     */
    public function addListField($class, array $fields)
    {
        $class = $this->getClassName($class);
        $this->list_fields[$class] = $fields;
    }
    
    /**
     * Returns the best fitting list of fields to list the given class
     * @param $class int|string|ORMObject any reference to a class
     * @return array of string: List of fields to display in the list
     */
    public function getListField($class): array
    {
        $class = $this->getClassName($class);
        while (!isset($this->list_fields[$class])) {
            $class = get_parent_class($class);
        }
        return $this->list_fields[$class];
    }
    
    public function addResponse(string $action, string $class, $response)
    {
        if (!in_array($action,$this->allowed_actions)) {
            throw new \Exception("'$action' is not a allowed action.");
            return;
        }
    }
    
    public function getResponse(string $action, $item, $additional)
    {
        switch ($action) {
            case 'add':
                if (is_string($item) && class_exists($item)) {
                    return $this->addObject($item, $additional);
                } else {
                    throw new \Exception(__("Can't resolv item to an object."));                    
                }
                break;
            case'show':
                if (is_int($item)) {
                    return $this->showObject($item);
                } else if ($item instanceof ORMObject) {
                    return $this->showObject($item->getID());
                } else {
                    throw new \Exception(__("Can't resolv item to an object."));
                }                
                break;
            case 'edit':
                if (is_int($item)) {
                    return $this->editObject($item);
                } else if ($item instanceof ORMObject) {
                    return $this->editObject($item->getID());
                } else {
                    throw new \Exception(__("Can't resolv item to an object."));                    
                }
                break;
            case 'groupedit':
                break;
            case 'list':
                if (is_string($item) && class_exists($item)) {
                    return $this->listObjects($item, $additional);
                } else {
                    throw new \Exception(__("Can't resolv item to an object."));
                }
                break;
            default:
                throw new \Exception(__("':action' is not an allowed action.",['action'=>$action]));                
        }
    }
    
    protected function addObject(string $class)
    {
        
    }
    
    /**
     * Returns an show page for the given object with the id $id
     * @param string $class
     */
    protected function showObject(int $id)
    {
        
    }
    
    /**
     * Return the edit dialog for the given object with the id $id
     * @param int $id
     */
    protected function editObject(int $id)
    {
        
    }
    
    /**
     * Returns a list of the given objects
     * @param string $class
     */
    protected function listObjects(string $class, $additional)
    {
        
    }
    
    public function execAddObject()
    {
        
    }
    
    public function execEditObject()
    {
        
    }
    
    public function deleteObject(int $id)
    {
        
    }
}
