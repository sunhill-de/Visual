<?php

namespace Sunhill\Visual\Response\Dialog;

class DialogEntryText extends DialogEntryWithEntries
{
    
    protected $rows = 5;
    
    protected $cols = 30;
    
    public function setRows(int $rows): DialogEntryText
    {
        $this->rows = $rows;    
    }
    
    public function setCols(int $cols): DialogEntryText
    {
        $this->cols = $cols;    
    }
    
    public function getHTMLCode(): string
    {
        $result = '<textarea name="'.$this->name.'" rows="'.$this->rows.'" cols="'.$this->cols.'">';
        if (!empty($this->value)) { $result .= $this->value; }
        $result .= '</textarea>';
        return $result;    
    }
    
}