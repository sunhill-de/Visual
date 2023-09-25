<?php

namespace Sunhill\Visual\Response\Dialog;

class DialogEntryList extends DialogEntry
{

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
    
    protected function getSearchField()
    {
        switch ($this->type) {
            case 'string':
                return 'text';
        }
    }
    
    public function getHTMLCode(): string
    {
       $result = '<div class="columns"><div class="control column"><label class="label is-size-7">';
       $result .= __( "Search" ).'</label>';
       $result .= '<input class="input is-small" type="'.$this->getSearchField().'" name="input_'.$this->name.'" id="input_'.$this->name.'" /></div>';
       $result .= '<div class="control column is-narrow"><label class="label is-size-7">&nbsp;</label>';
       $result .= '<input class="button is-info is-small" type="button" value="+" onClick="addEntry( \''.$this->name.'\', false )"></div>';
       $result .= '<div class="column is-narrow"><label class="label is-size-7">'.__( "Current setting" ).'</label>';
       $result .= '<div class="dynamic_list" id="list_'.$this->name.'"></div></div>';
       $result .= '<div class="column">&nbsp;</div'; 
       $result .= '</div>';

       return $result;
    }

}