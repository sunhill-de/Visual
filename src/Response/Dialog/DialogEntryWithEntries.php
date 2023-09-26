<?php

namespace Sunhill\Visual\Response\Dialog;

abstract class DialogEntryWithEntries extends DialogEntry
{
   
   protected $entries = [];
   
   public function entries(array $entries): DialogEntryWithEntries
   {
       $this->entries = $entries;
       return $this;
   }
   
}