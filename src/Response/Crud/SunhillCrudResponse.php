<?php

namespace Sunhill\Visual\Response\Crud;

use Sunhill\Visual\Response\SunhillResponseBase;
use Sunhill\Visual\Response\Lists\ListDescriptor;
use Sunhill\Visual\Response\SunhillUserException;

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
     * Opens a dialog to add another entity
     */
    public function add()
    {
        
    }
    
    /**
     * Checks the entered values and adds the given entity
     * @param array $parameters
     */
    public function execAdd(array $parameters)
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
    public function execEdit($id, array $parameters)
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