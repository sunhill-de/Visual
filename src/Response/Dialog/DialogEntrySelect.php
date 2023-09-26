<?php

namespace Sunhill\Visual\Response\Dialog;

class DialogEntrySelect extends DialogEntryWithEntries
{
   
   public function getHTMLCode(): string
   {
       $result = '<select name="'.$this->name.'">';
       foreach ($this->entries as $name => $value) {
           $result .= '<option value='.$value;
           if (!empty($this->value) && ($this->value == $value)) {
               $result .= ' selected';
           }
           $result .= '>'.__($name).'</option>';
       }
       return $result.'</select>';
   }

}