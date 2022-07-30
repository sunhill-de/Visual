<?php

/**
 * @file GetProperties.php
 * Implements the GetProperties trait that is uses to retrieve
 * a list of properties that define a special feauture (e.g. "Editable")
 * @author Klaus Dimde
 * Lang en (complete)
 * Reviewstatus: 2022-07-30
 * Localization: complete
 * Documentation: unknown
 * Tests: unknown
 * Coverage: unknown
 * Dependencies: Classes
 */

namespace Sunhill\Visual\Traits;

use Sunhill\ORM\Facades\Classes;
use Sunhill\ORM\Objects\ORMObject;

trait GetProperties 
{

    /**
     * Depending on whats passed as item it tries to return the namespace of
     * that given class
     * @param unknown $item
     * If item is an int, that it's treated as a object Id
     * If item is a string, than it can be already a namespace of a class Id
     * If Item is a ORMObject return its class
     * @return unknown
     */
    protected function getNamespace($item)
    {
        if (is_int($item)) {
            // We think item is the id of an object
        } else if (is_string($item)) {
            if (class_exists($item)) {
                // trivial, it's
                return $item;
            } else {
                // It's a string so we think its the id of an class
                return Classes::getNamespaceOfClass($item);
            }
        } else if (is_a ($item,ORMObject::class)) {
            return $item::class;
        }
    }
    
    /**
     * Return all fields of the given class namepsace that fits the given feature
     * @param string $namespace
     * @param string $feature
     * @return \StdClass[]
     */
    protected function getFields(string $namespace, string $feature)
    {
        $fields = $namespace::staticGetProperties()->where($feature,true)->get();
        $result = [];
        foreach ($fields as $field) {
            $item = new \StdClass();
            $item->name = $field->getName();
            $result[] = $item;
        }
        return $result;
    }
    
    /**
     * Same as getFields excpet that we don't surely know the namespace yet
     * @param unknown $item
     * @param unknown $condition
     * @return unknown
     */
    protected function getFieldsThat($item, $condition)
    {
        $namespace = $this->getNamespace($item);
        return $this->getFields($namespace, $condition);
    }

    /**
     * Return all fields that are editable
     * @param unknown $item
     * @return unknown
     */
    protected function getEditable($item)
    {
        return $this->getFieldsThat($item, 'editable');
    }
    
    /**
     * Return all fields that are displayable
     * @param unknown $item
     * @return unknown
     */
    protected function getDisplayable($item)
    {
        return $this->getFieldsThat($item, 'displayable');
    }

    /**
     * Return all fields that are groupeditable
     * @param unknown $item
     * @return unknown
     */
    protected function getGroupeditable($item)
    {
        return $this->getFieldsThat($item, 'groupeditable');        
    }
}
