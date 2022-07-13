<?php

namespace Sunhill\Visual\Managers;

use Sunhill\ORM\Objects\ORMObject;
use Sunhill\ORM\Facades\Classes;
use Sunhill\Visual\Response\Database\Objects\ListObjectsResponse;
use Sunhill\Visual\Response\Database\Objects\AddObjectResponse;

class DialogManager
{
    
    /**
     * Stores the responses for different object actions 
     */
    protected $object_actions;

    protected $object_keyfields;
    
    protected $object_list_fields;
    
    private $object_allowed_actions = ['add','edit','groupedit','list','show'];
    
    /**
     * Initiates the dialog manager with the most basic (and normally functioning) responses.
     * The common ancestor for all orm objects is ORMObject, so the search routine will stop 
     * at least here, because for ORMObject a default response is given.
     */
    private function initManager()
    {
        $this->object_actions = [];
        foreach ($this->object_allowed_actions as $action) {
            $this->object_actions[$action] = [];
        }
        $this->addObjectResponse('list',ORMObject::class,ListObjectsResponse::class);
        $this->addObjectResponse('add',ORMObject::class,AddObjectResponse::class);
        
        $this->object_list_fields = [];
        $this->addObjectListFields(ORMObject::class,['uuid','keyfield']);
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
            if (class_exists($item) && is_a($item,ORMObject::class)) {
                return $item; // Trivial, we already have a class
            } else {
               return Classes::getNamespaceOfClass($item); 
            }
        } else if (is_a($item,ORMObject::class)) {
        
        } else if (is_int($item)) {
            // We interpret the item as the object ID
        }    
    }
    
    /**
     * Searches in the given array for a class in the ancestors that define an entry.
     * Be careful: this method doesn't stop so there must be a common ancestor in the given list
     * @param array $search
     * @param string $class
     * @return unknown
     */
    protected function getBestEntry(array $search, string $class)
    {
        while (!isset($search[$class])) {
            $class = get_parent_class($class);
        }
        return $search[$class];
    }
    
    /**
     * Adds a list of field that should be displayed when objects of the given class are listed
     * @param $class int|string|ORMObject any reference to a class
     * @param $fields array: a list of strings that define the fields for the list
     */
    public function addObjectListFields($class, array $fields)
    {
        $class = $this->getClassName($class);
        $this->object_list_fields[$class] = $fields;
    }
    
    /**
     * Returns the best fitting list of fields to list the given class
     * @param $class int|string|ORMObject any reference to a class
     * @return array of string: List of fields to display in the list
     */
    public function getObjectListFields($class): array
    {
        $class = $this->getClassName($class);
        return $this->getBestEntry($this->object_list_fields,$class);
    }
    
    public function addObjectResponse(string $action, string $class, $response)
    {
        if (!in_array($action,$this->object_allowed_actions)) {
            throw new \Exception(__("':action' is not an allowed action.",['action'=>$action]));
            return;
        }
        $class = $this->getClassName($class);
        $this->object_actions[$action][$class] = $response;
    }
    
    public function addKeyfield(string $class,string $keyfield)
    {
        
    }
    
    public function getKeyfield($object)
    {
        $class = get_class($object);    
    }
    
    public function getObjectResponse(string $action, $item, $additional=null)
    {
        $item = $this->getClassName($item);
        
        switch ($action) {
            case 'add':
                return $this->addObject($item);
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
        return $this->getBestEntry($this->object_actions['add'],$class);
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
        return $this->getBestEntry($this->object_actions['list'],$class);        
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
