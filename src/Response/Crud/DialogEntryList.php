<?php

namespace Sunhill\Visual\Response\Crud;

class DialogEntryList extends DialogEntry
{

    protected $lookup;
    
    protected $additional1 = '';
    
    protected $additional2 = '';
    
    
    public function element(string $type): DialogEntryList
    {
        $this->type = $type;
        return $this;
    }
    
    public function lookup(string $target): DialogEntryList
    {
        $this->lookup = $target;
        return $this;
    }
    
    public function lookup_additional($additional1, $additional2 = ''): DialogEntryList
    {
        $this->additional1 = $additional1;
        $this->additional2 = $additional2;
        return $this;
    }
    
    protected function getSearchField()
    {
        switch ($this->type) {
            case 'string':
                return 'text';
                break;
        }
    }
    
    public function loadValue(array $values)
    {
        $newvalue = [];
        for ($i=0;$i<count($values[$this->name]);$i++) {
            $entry = new \StdClass();
            $entry->key = $values['name_'.$this->name][$i];
            $entry->value = $values[$this->name][$i];
            $newvalue[] = $entry;
        }
        $this->value($newvalue);
    }
    
    public function getHTMLCode(): string
    {
       $result = '<div class="columns"><div class="control column is-narrow"><label class="label is-size-7">';
       $result .= __( "Search" ).'</label>';
       $result .= '<input class="input is-small" type="'.$this->getSearchField().'" name="input_'.$this->name.'" id="input_'.$this->name.'" />';
       $result .= '<input type="hidden" name="value_'.$this->name.'" id="value_'.$this->name.'">';
       $result .= '</div>';
       $result .= '<div class="control column is-narrow"><label class="label is-size-7">&nbsp;</label>';
       $result .= '<input class="button is-info is-small" type="button" value="+" onClick="addEntry( \''.$this->name.'\', false )"></div>';
       $result .= '<div class="column is-narrow"><label class="label is-size-7">'.__( "Current setting" ).'</label>';
       $result .= '<div class="dynamic_list" id="list_'.$this->name.'">';
       if (!empty($this->value)) {
           foreach ($this->value as $entry) {
               $result .= '<div class="control"><input type="hidden" name="'.$this->name.'[]" id="'.$this->name.'[]" value="'.$entry->value.'"/>';
               $result .= '<input readonly type="input" class="input is-small dynamic_entry" name="name_'.$this->name.'[]" id="value_'.$this->name.'[]" value="'.$entry->key.'" onclick="removeElement( $(this) )" /></div>';
           }
       }
       $result .= '</div></div>';
       $result .= '<div class="column">&nbsp;</div>'; 
       $result .= '</div>';
       if (!empty($this->lookup)) {
           $result .= '<script>$( function() { ';
           $result .= 'lookupInput(\''.$this->name.'\',\''.$this->lookup.'\', true,\''.$this->additional1.'\',\''.$this->additional2.'\');';
           $result .= '})</script>';
       }
       return $result;
    }

    public function getEmptyValue()
    {
        return [];
    }
    
}