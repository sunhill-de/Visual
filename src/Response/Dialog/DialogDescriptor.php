<?php

namespace Sunhill\Visual\Response\Dialog;

use Sunhill\Visual\Response\SunhillDescriptor;

class DialogDescriptor extends SunhillDescriptor
{
    
    public function string()
    {
        $entry = new DialogEntryString();
        $this->addEntry($entry);
        return $entry;
    }
    
    public function password()
    {
        
    }
    
    public function radio()
    {
        
    }
    
    public function checkbox()
    {
        
    }
    
    public function color()
    {
        
    }
    
    public function date()
    {
        
    }
    
    public function datetime()
    {
        
    }
    
    public function number()
    {
        
    }
    
    public function time()
    {
        
    }
    
    public function text()
    {
        
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
}