<?php

namespace Sunhill\Visual\Response\Crud;

class DialogEntryInput extends DialogEntry
{
    
    protected $element_name = '';
    
    public function setElementName(string $name): DialogEntryInput
    {
        $this->element_name = $name;
        return $this;
    }
    
    public function getHTMLCode(): string
    {
        return '<input type="'.$this->element_name.'" name="'.$this->name.'"'.
               (empty($this->class)?'':' class="'.$this->class.'"').(empty($this->value)?'':' value="'.$this->value.'"').'>';
    }
    
}