<?php

namespace Sunhill\Visual\Response\Dialog;

class DialogEntryString extends DialogEntry
{
    
   public function getHTMLCode(): string
   {
        return '<input type="text" name="'.$this->name.'">';       
   }

}