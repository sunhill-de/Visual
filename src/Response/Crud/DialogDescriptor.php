<?php

namespace Sunhill\Visual\Response\Crud;

use Sunhill\Visual\Response\SunhillDescriptor;

class DialogDescriptor extends SunhillDescriptor
{
    
    public function string()
    {
        $entry = new DialogEntryInput();
        $entry->setElementName('input');
        $this->addEntry($entry);
        return $entry;
    }
    
    public function password()
    {
        $entry = new DialogEntryInput();
        $entry->setElementName('password');
        $this->addEntry($entry);
        return $entry;        
    }
    
    public function radio()
    {
        $entry = new DialogEntryRadio();
        $this->addEntry($entry);
        return $entry;        
    }
    
    public function checkbox()
    {
        $entry = new DialogEntryCheckbox();
        $this->addEntry($entry);
        return $entry;        
    }
    
    public function color()
    {
        $entry = new DialogEntryInput();
        $entry->setElementName('color');        
        $this->addEntry($entry);
        return $entry;        
    }
    
    public function date()
    {
        $entry = new DialogEntryInput();
        $entry->setElementName('date');
        $this->addEntry($entry);
        return $entry;        
    }
    
    public function datetime()
    {
        $entry = new DialogEntryInput();
        $entry->setElementName('datetime-local');
        $this->addEntry($entry);
        return $entry;        
    }
    
    public function number()
    {
        $entry = new DialogEntryInput();
        $entry->setElementName('number');
        $this->addEntry($entry);
        return $entry;        
    }
    
    public function time()
    {
        $entry = new DialogEntryInput();
        $entry->setElementName('time');
        $this->addEntry($entry);
        return $entry;        
    }
    
    public function text()
    {
        $entry = new DialogEntryText();
        $this->addEntry($entry);
        return $entry;        
    }
    
    public function select()
    {
        $entry = new DialogEntrySelect();
        $this->addEntry($entry);
        return $entry;        
    }
    
    public function list()
    {
        $entry = new DialogEntryList();
        $this->addEntry($entry);
        return $entry;        
    }
    
    public function inputLookup()
    {
        $entry = new DialogEntryInputLookup();
        $this->addEntry($entry);
        return $entry;        
    }
}