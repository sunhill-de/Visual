<?php

namespace Sunhill\Visual\Response\Crud;

use Sunhill\Visual\Response\SunhillResponseBase;
use Sunhill\Visual\Response\Crud\ListDescriptor;
use Sunhill\Visual\Response\SunhillUserException;
use Illuminate\Http\Request;

abstract class SunhillCrudResponse extends SunhillSemiCrudResponse
{
    
    /**
     * Indicates that this crud response provides a functioning [confirm,exec]groupdelete
     * @return bool
     */
    public static function providesGroupDelete(): bool
    {
        return in_array('delete',static::$group_action);
    }
    
    /**
     * Indicates that this crud response provides a functioning groupedit|execgroupedit
     * @return bool
     */
    public static function providesGroupEdit(): bool
    {
        return in_array('edit',static::$group_action);
    }
    
    /**
     * Defines the elements of the dialog
     * @param DialogDescriptor $descriptor
     */
    abstract protected function defineDialog(DialogDescriptor $descriptor);
    
    /**
     * Finally adds the entry to the database
     * @param unknown $parameters
     */
    abstract protected function doExecAdd($parameters);
    
    abstract protected function getEditValues();
    abstract protected function doExecEdit($parameters);
    
    protected $error = [];
    
    protected function fillFormTemplate(string $route_addition, array $values = [])
    {        
        $descriptor = new DialogDescriptor();
        $this->defineDialog($descriptor);
        $entries = [];
        foreach ($descriptor as $entry) {
            $element = new \StdClass();
            $element->label = $entry->getLabel();
            $element->name = $entry->getName();
            if (array_key_exists($element->name,$this->error)) {
                $element->error = $this->error[$element->name];
            }
            if (array_key_exists($element->name, $values) || array_key_exists('value_'.$element->name, $values)) {
                $entry->loadValue($values);
            }
            $element->dialog = $entry->getHTMLCode();
            $entries[] = $element;
        }

        $result = [];
        $result = array_merge($result, $this->getCommonParameters());
        $result = array_merge($result, [
            'dialog_method'=>'post',
            'dialog_route'=>static::$route_base.'.'.$route_addition,
            'dialog_route_parameters'=>$this->getRoutingParameters(),
            'elements'=>$entries,            
        ]);
        return view('visual::crud.dialog', $result);
    }
    
    /**
     * Opens a dialog to add another entity
     */
    public function add()
    {
        return $this->fillFormTemplate('execadd');        
    }
    
    /**
     * Checks the entered values and adds the given entity
     * @param array $parameters
     */
    public function execAdd(Request $parameters)
    {
        
    }
    
    /**
     * Opens a dialog to edit the given entity
     * @param unknown $id = Normally an integer that identies the entity
     */
    public function edit($id)
    {
        
    }
    
    /**
     * Checks the entered values and updates the given entity
     * @param unknown $id = Normally an integer that identies the entity
     * @param array $parameters
     */
    public function execEdit($id, Request $parameters)
    {
        
    }
    
    /**
     * Deletes the given entity
     * @param unknown $id = Normally an integer that identies the entity
     */
    public function delete($id)
    {
        
    }
    
    /**
     * Opens a dialog to change the groupeditable fields of the given entities
     * @param array $ids an array of ids (normally integers) that identify the entities
     */
    public function groupEdit(array $ids)
    {
        
    }
    
    /**
     * Checks the entered values and changes them on the given entities
     * @param array $ids
     * @param array $parameters
     */
    public function execGroupEdit(array $ids, array $parameters)
    {
        
    }
    
    /**
     * Displays a summary of the entities to delete and asks for a confirmation
     * @param array $ids
     */
    public function confirmGroupDelete(array $ids)
    {
        
    }
    
    /**
     * Deletes the entities with the given ids
     * @param array $ids
     */
    public function executeGroupDelete(array $ids)
    {
        
    }
    
}