<?php

namespace Sunhill\Visual\Response\Dialog;

class DialogEntryCheckbox extends DialogEntry
{
    
    public function getHTMLCode(): string
    {
        $result = '<input type="checkbox" name="'.$this->name.'"'.
            (empty($this->class)?'':' class="'.$this->class.'"');
            if (!empty($this->value) && ($this->value)) {
                $result .= ' checked';
            }
        $result .= '>';
        return $result;
    }
    
}