<?php

namespace Sunhill\Visual\Response\Dialog;

class DialogEntryInputLookup extends DialogEntry
{
    
    protected $element_name = '';
    
    protected $lookup;
    
    protected $additional1 = '';
    
    protected $additional2 = '';
    
    public function element(string $type): DialogEntryInputLookup
    {
        $this->type = $type;
        return $this;
    }
    
    public function lookup(string $target): DialogEntryInputLookup
    {
        $this->lookup = $target;
        return $this;
    }
    
    public function lookup_additional($additional1, $additional2 = ''): DialogEntryInputLookup
    {
        $this->additional1 = $additional1;
        $this->additional2 = $additional2;
        return $this;
    }
    
    public function getDialogName(): string
    {
        return 'value_'.$this->getName();
    }
    
    public function getHTMLCode(): string
    {
        $result = '<input type="text" name="input_'.$this->name.'" id="input_'.$this->name.'"'.
                  (empty($this->class)?'':' class="'.$this->class.'"').(empty($this->value)?'':' value="'.$this->value.'"').'>';
        $result .= '<input type="hidden" name="value_'.$this->name.'" id="value_'.$this->name.'">';
        $result .= '<script>$( function() { lookupInput(\''.$this->name.'\',\''.$this->lookup.'\');';
        $result .= '})</script>';
        
        return $result;
    }
    
}