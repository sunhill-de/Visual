<?php

namespace Sunhill\Visual\Response\Dialog;

class DialogEntryCheckbox extends DialogEntry
{
    
    public function getHTMLCode(): string
    {
        return '<input type="checkbox" name="'.$this->name.'"'.
               (empty($this->class)?'>':' class="'.$this->class.'">');
    }
    
}