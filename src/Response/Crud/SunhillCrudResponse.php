<?php

namespace Sunhill\Visual\Response\Crud;

use Sunhill\Visual\Response\SunhillResponseBase;
use Sunhill\Visual\Response\Crud\ListDescriptor;
use Sunhill\Visual\Response\Crud\Exceptions\SunhillUserException;
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
    
    /**
     * Returns the current values of entry with id $id
     * @param unknown $id
     */
    abstract protected function getEditValues($id);

    /**
     * Finally updates the entry with id $id with the parameters in $parameters
     * @param unknown $id
     * @param unknown $parameters
     */
    abstract protected function doExecEdit($id, $parameters);
    
    protected $error = [];
    
    /**
     * Creates a dialog descriptor and fills it with the current crud response dialog descriptor
     * @return \Sunhill\Visual\Response\Crud\DialogDescriptor
     */
    protected function getDialogDescriptor()
    {
        $descriptor = new DialogDescriptor();
        $this->defineDialog($descriptor);
        
        return $descriptor;
    }
    
    protected function fillFormTemplate(string $route_addition, array $values = [], $id = null, $groupeditable = [])
    {        
        $descriptor = $this->getDialogDescriptor();

        $entries = [];
        
        foreach ($descriptor as $entry) {
            if (!empty($groupeditable) && !$entry->getGroupeditable()) {
                continue;
            }
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
        if (isset($groupeditable)) {
            $result['ids'] = $groupeditable;
        }
        $result = array_merge($result, $this->getCommonParameters());
        $result = array_merge($result, [
            'dialog_method'=>'post',
            'dialog_route'=>static::$route_base.'.'.$route_addition,
            'dialog_route_parameters'=>$this->getRoutingParameters($id),
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
    
    protected function handleDescriptorEntry(&$result, $entry, $request)
    {
        if (request()->has($entry->getDialogName()) && !empty($request->input($entry->getDialogName()))) {
            switch ($entry::class) {
                case DialogEntryList::class:
                    $result[$entry->getName()] = $request->input($entry->getDialogName());
                    $result['name_'.$entry->getName()] = $request->input('name_'.$entry->getDialogName());
                    break;
                case DialogEntryInputLookup::class:
                    $result['input_'.$entry->getName()] = $request->input('input_'.$entry->getName());
                    $result['value_'.$entry->getName()] = $request->input('value_'.$entry->getName());
                default:
                    $result[$entry->getName()] = $request->input($entry->getDialogName());
            }
        } else {
            if ($entry->getRequired()) {
                $this->inputError($entry, __('This field is required.'));
            }
            $result[$entry->getName()] = $entry->getEmptyValue();
        }        
    }
    
    protected function parseInput(Request $request, $groupedit = false)
    {
        $descriptor = $this->getDialogDescriptor();
        $result = [];
        foreach ($descriptor as $entry) {
            if (!$groupedit || $entry->getGroupeditable()) {
                $this->handleDescriptorEntry($result, $entry, $request);
            }
        }
        $this->input = $result;
        return $result;
    }
    
    protected function inputError($entry, string $message)
    {
        if (is_a($entry,DialogEntry::class)) {
            $this->error[$entry->getName()] = $message;
        } else {
            $this->error[$entry] = $message;            
        }
    }
    
    /**
     * Checks the entered values and adds the given entity
     * @param array $parameters
     */
    public function execAdd(Request $parameters)
    {
        $input = $this->parseInput($parameters);
        if ($this->error) {
            return $this->fillFormTemplate('execadd', $parameters->post());
        }
        if (($result = $this->doExecAdd($input)) == false) {
            return $this->fillFormTemplate('execadd', $parameters->post());            
        } else {
            return $result;
        }
    }
    
    /**
     * Opens a dialog to edit the given entity
     * @param unknown $id = Normally an integer that identies the entity
     */
    public function edit($id)
    {
        try {
            $this->checkID($id);
        } catch (SunhillUserException $e) {
            return $this->exception($e);
        }
        return $this->fillFormTemplate('execedit', $this->getEditValues($id), $id);
    }
    
    /**
     * Checks the entered values and updates the given entity
     * @param unknown $id = Normally an integer that identies the entity
     * @param array $parameters
     */
    public function execEdit($id, Request $parameters)
    {
        try {
            $this->checkID($id);
        } catch (SunhillUserException $e) {
            return $this->exception($e);
        }
        
        $input = $this->parseInput($parameters);
        if ($this->error) {
            return $this->fillFormTemplate('execedit', $parameters->post(),$id);
        }
        if (($result = $this->doExecEdit($id, $input)) == false) {
            return $this->fillFormTemplate('execedit', $parameters->post(),$id);
        } else {
            return $result;
        }        
    }
    
    abstract protected function doDelete($id);
    
    /**
     * Deletes the given entity
     * @param unknown $id = Normally an integer that identies the entity
     */
    public function delete($id)
    {
        try {
            $this->checkID($id);
        } catch (SunhillUserException $e) {
            return $this->exception($e);
        }
        
        return $this->doDelete($id);
    }
    
    /**
     * Opens a dialog to change the groupeditable fields of the given entities
     * @param array $ids an array of ids (normally integers) that identify the entities
     */
    public function groupEdit(array $ids)
    {
        return $this->fillFormTemplate('execgroupedit', [], null, $ids);        
    }
    
    abstract protected function doExecGroupEdit(array $ids, array $parameters);
    
    /**
     * Checks the entered values and changes them on the given entities
     * @param array $ids
     * @param array $parameters
     */
    public function execGroupEdit(array $ids, Request $parameters)
    {
         return $this->doExecGroupEdit($ids, $this->parseInput($parameters, true));
    }
    
    /**
     * Returns an array in the form $id->key
     * @param unknown $ids array of ids
     * @return array
     */
    abstract protected function getRecordKeys($ids): array;
    
    protected function getGroupDeleteParams($ids)
    {
        $result = $this->getCommonParameters();
        $result['action'] = route(static::$route_base.'.execgroupdelete', $this->getRoutingParameters());        
        $result['entries'] = [];
        $keys = $this->getRecordKeys($ids);
        foreach ($ids as $id) {
            $result['entries'][] = $this->getStdClass(['id'=>$id,'key'=>$keys[$id]]);
        }
        return $result;
    }
    
    /**
     * Displays a summary of the entities to delete and asks for a confirmation
     * @param array $ids
     */
    public function confirmGroupDelete(array $ids)
    {
        return view('visual::crud.confirm', $this->getGroupDeleteParams($ids));
    }
    
    /**
     * Finally deletes all entries with the given ids
     * @param array $ids
     */
    abstract protected function doExecGroupDelete(array $ids);
    
    /**
     * Deletes the entities with the given ids
     * @param array $ids
     */
    public function execGroupDelete(array $ids)
    {
        return $this->doExecGroupDelete($ids);
    }
    
}