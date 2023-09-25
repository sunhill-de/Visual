<?php

namespace Sunhill\Visual\Response\Dialog;

class DialogEntrySelect extends DialogEntry
{
   
   protected $entries = [];
   
   public function entries(array $entries): DialogEntrySelect
   {
       $this->entries = $entries;
       return $this;
   }
   
   public function getHTMLCode(): string
   {
       $result = '<select name="'.$this->name.'">';
       foreach ($this->entries as $name => $value) {
           $result .= '<option value='.$value.'>'.__($name).'</option>';
       }
       return $result.'</select>';
   }

}