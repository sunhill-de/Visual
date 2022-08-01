<?php

namespace Sunhill\Visual\Components;

use Illuminate\View\Component;
use Sunhill\ORM\Facades\Classes;

class Input extends Component
{
    
    public $id;
    
    public $name;
    
    public $action;
    
    public $property;
    
    public $class;
    
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
        switch ($this->property->getType()) {
            case 'Varchar':
                return view(
                    'visual::components.varchar', 
                    [
                        'name'=>$this->name
                    ]);
            case 'Integer':
                return view('visual::components.integer', ['name'=>$this->name]);
            case 'Date':
                return view('visual::components.date', ['name'=>$this->name]);
            case 'Time':
                return view('visual::components.time', ['name'=>$this->name]);
            case 'Object':
                return view(
                    'visual::components.object', 
                    [
                        'name'=>$this->name,
                        'allowed_objects'=>json_encode(Classes::getNamespaceOfClass($this->class)::getPropertyObject($this->name)->getAllowedObjects())
                    ]);
            case 'Float':
                return view('visual::components.float', ['name'=>$this->name]);
            case 'ArrayOfStrings':
                return view(
                    'visual::components.arrayofstrings',
                    [
                        'name'=>$this->name
                    ]
                );
            case 'ArrayOfObjects':
                return view(
                'visual::components.arrayofobjects',
                [
                'name'=>$this->name
                ]
                );
            case 'Enum':
                return view(
                    'visual::components.enum', 
                     [
                        'name'=>$this->name,
                        'entries'=>Classes::getNamespaceOfClass($this->class)::getPropertyObject($this->name)->getEnumValues()
                     ]);
            default:
                return view('visual::components.notimplemented', ['class'=>$this->class,'name'=>$this->name, 'type'=>$this->property->getType()]);
        }
    }
}
