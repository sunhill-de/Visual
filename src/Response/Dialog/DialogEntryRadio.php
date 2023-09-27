<?php

namespace Sunhill\Visual\Response\Dialog;

class DialogEntryRadio extends DialogEntryWithEntries
{
    
    public function getHTMLCode(): string
    {
        $result = '<fieldset>';
        foreach ($this->entries as $name => $value) {
            $result .= '<label for="'.$this->name.'_'.$value.'"'
            .(empty($this->class)?'>':' class="'.$this->class.'">').$name;
            $result .= '<input type="radio" id="'.$value.'" name="'.$this->name.'" value="'.$value.'"';
            if (!empty($this->value) && ($this->value == $value)) {
                $result .= ' checked';                
            }
            $result .= '></label>';
        }
        $result .= '</fieldset>';
        return $result;    
    }
    
}