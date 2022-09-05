<?php

namespace Sunhill\Visual\Components;

use Illuminate\View\Component;
use Sunhill\ORM\Facades\Classes;
use Sunhill\ORM\Facades\Objects;
use Sunhill\Visual\Facades\Dialogs;

class Input extends Component
{
    
    public $id;
    
    public $name;
    
    public $action;
    
    public $property;
    
    public $class;
    
    public $object;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id,$name,$action)
    {
        switch ($this->action = $action) {
            case "add":
                // id should be a class name
                $this->class = $id;
                $namespace = Classes::getNamespaceOfClass($id);
                $this->property = $namespace::getPropertyObject($name);
                break;
            case "edit":
                $this->id = $id;
                $this->object = Objects::load($id);
                $this->class = Classes::getClassName($this->object);
                $namespace = $this->object::class;
                $this->property = $namespace::getPropertyObject($name);                
                break;
            case "groupedit":
                break;
            default:
                throw new \Exception(__("Invalid action: ':action'",['action'=>$action]));
        }
        $this->id = $id;
        $this->name  = $name;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $name = $this->name;
        switch ($this->property->getType()) {
            case 'Varchar':
                return view(
                    'visual::components.varchar', 
                    [
                        'name'=>$this->name,
                        'value'=>(is_null($this->object))?null:$this->object->$name
                    ]);
            case 'Integer':
                return view('visual::components.integer', 
                [
                    'name'=>$this->name,
                    'value'=>(is_null($this->object))?null:$this->object->$name                    
                ]);
            case 'Date':
                return view('visual::components.date', 
                [
                    'name'=>$this->name,
                    'value'=>(is_null($this->object))?null:$this->object->$name
                    ]);
            case 'Time':
                return view('visual::components.time', 
                [
                    'name'=>$this->name,
                    'value'=>(is_null($this->object))?null:$this->object->$name                    
                ]);
            case 'Object':
                if (is_null($this->object) || is_null($this->object->$name)) {
                    $key = null;
                    $id  = null;
                } else {
                    $id  = $this->object->$name->getID();
                    $key = Dialogs::getObjectKeyfield($this->object->$name);
                }
                return view(
                    'visual::components.object', 
                    [
                        'name'=>$this->name,
                        'allowed_objects'=>json_encode(Classes::getNamespaceOfClass($this->class)::getPropertyObject($this->name)->getAllowedObjects()),
                        'obj_key'=>$key,
                        'obj_id'=>$id,
                    ]);
            case 'Float':
                return view('visual::components.float', 
                [
                    'name'=>$this->name,
                    'value'=>(is_null($this->object))?null:$this->object->$name
                ]);
            case 'ArrayOfStrings':
                if (!is_null($this->object) && !is_null($this->object->$name)) {
                    $values = [];
                    foreach ($this->object->$name as $entry) {
                        $values[] = $entry;
                    }
                } else {
                        $values = null;
                }
                return view(
                    'visual::components.arrayofstrings',
                    [
                        'name'=>$this->name,
                        'values'=>$values
                    ]
                );
            case 'ArrayOfObjects':
                if (!is_null($this->object) && !is_null($this->object->$name)) {
                    $values = [];
                    foreach ($this->object->$name as $entry) {
                        $entry = Objects::load($entry);
                        $res_entry = new \StdClass();
                        $res_entry->key = Dialogs::getObjectKeyfield($entry);
                        $res_entry->value = $entry->getID();
                        $values[] = $res_entry;
                    }
                } else {
                    $values = null;
                }
                return view(
                'visual::components.arrayofobjects',
                [
                    'name'=>$this->name,
                    'values'=>$values
                ]
                );
            case 'Enum':
                return view(
                    'visual::components.enum', 
                     [
                        'name'=>$this->name,
                        'entries'=>Classes::getNamespaceOfClass($this->class)::getPropertyObject($this->name)->getEnumValues(),
                        'selected'=>(is_null($this->object))?"":$this->object->$name
                     ]);
            default:
                return view('visual::components.notimplemented', ['class'=>$this->class,'name'=>$this->name, 'type'=>$this->property->getType()]);
        }
    }
}
