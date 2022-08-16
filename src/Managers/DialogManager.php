<?php

namespace Sunhill\Visual\Managers;

use Sunhill\ORM\Objects\ORMObject;
use Sunhill\ORM\Facades\Classes;
use Sunhill\ORM\Utils\ObjectList;

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
        
        $this->object_keyfields = [];
        $this->addObjectKeyfield(ORMObject::class,':uuid');
    }
    
    public function __construct()
    {
        $this->initManager();
    }
    
    /**
     * Depending on whats passed as parameter return the php class name
     * @test Unit/DialogTest::testGetClassName and ::testGetClassNameWithObject
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
            return $item::class;        
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
    
    public function addObjectKeyfield(string $class,string $keyfield)
    {
        $this->object_keyfields[$class] = $keyfield;   
    }
    
    public function getObjectKeyfield($object)
    {
        if (empty($object)) {
            return "";
        }
        $keyfield = $this->getBestEntry($this->object_keyfields,get_class($object));
        $vars = preg_match_all('/\:(\S+)/s',$keyfield,$matches);
        foreach ($matches[1] as $match) {
            $keyfield = str_replace(':'.$match,$object->$match,$keyfield);
        }
        return $keyfield;
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

    /**
     * Tests, if the given list has an entry with the id $id
     * @todo move me to ORM
     * @param ObjectList $list
     * @param int $id
     * @return bool
     * test: DialogsTest::testObjectListHasId
     */
    protected function objectListHasId(ObjectList $list,int $id): bool
    {
        for ($i=0;$i<$list->count();$i++) {
            if ($list->getID($i) == $id) {
                return true;
            }
        }
        return false;
    }
    
    /**
     * Merges all entries from list2 to list1 if they are not already in list1
     * @todo Move me to ORM
     * @param unknown $list1
     * @param unknown $list2
     * @return unknown
     */
    protected function mergeObjectLists($list1,$list2)
    {
        for ($i=0;$i<$list2->count();$i++) {
            if (!$this->objectListHasId($list1,$list2->getID($i))) {
                $list1->add($list2->getID($i));
            }
        }
        return $list1;
    }
    
    /**
     * Returns an ObjectList of objects that fit to the given keyfield search
     * @param string $namespace
     * @param string $search
     * @param bool $anywhere
     * @param int $limit
     * @return ObjectList
     */
    protected function searchKeyfieldForClass(string $namespace, string $search, bool $anywhere, int $limit=10): ObjectList
    {
        $keyfield = $this->getBestEntry($this->object_keyfields,$namespace);        
        preg_match_all('/\:(\S+)/s',$keyfield,$matches);
        $query = $namespace::search();
        foreach ($matches[1] as $var) {
            if ($anywhere) {
                $query = $query->orWhere($var,'consists',$search);
            } else {
                $query = $query->orWhere($var,'begins with',$search);
            }
        }
        return $query->limit(0,$limit)->get();
    }

    protected function reLimitObjectList(ObjectList $list, int $limit)
    {
        $result = new ObjectList();
        $i=0;
        while (($i<$list->count()) && ($i<$limit)) {
            $result->add($list->getID($i));
            $i++;
        }
        return $result;
    }
    
    /**
     * Searches all classes that fit to the search term $search in their keyfield(s)
     * Depending on $anywhere: 
     *  true = the term $search can be anywhere in any keyfield
     *  false = the keyfield has to start with $search
     * @param string $class
     * @param string $search
     * @param bool $anywhere
     */
    public function searchKeyfield(string $class, string $search, bool $anywhere=false, int $limit=10)
    {
        $namespace = Classes::getNamespaceOfClass($class);        
        $keyfield = $this->getBestEntry($this->object_keyfields,$namespace);
        preg_match_all('/\:(\S+)/s',$keyfield,$matches);
        $query = $namespace::search();
        foreach ($matches[1] as $var) {
            if ($anywhere) {
                $query = $query->where($var,'consists',$search);
            } else {
                $query = $query->where($var,'begins with',$search);                
            }
        }
        $query_result = $query->get();
        $result = [];
        foreach ($query_result as $single_result) {
            $result[] = ['keyfield'=>$this->getObjectKeyfield($single_result),'id'=>$single_result->getID()];   
        }
        return $result;
    }
}
