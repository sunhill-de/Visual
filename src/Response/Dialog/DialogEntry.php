<?php

namespace Sunhill\Visual\Response\Dialog;

abstract class DialogEntry
{
    
    protected $label = '';
    
    protected $name = '';
    
    protected $required = false;
    
    protected $class = null;
    
    public function label(string $label): DialogEntry
    {
        $this->label = $label;
        return $this;
    }
    
    public function getLabel(): string
    {
        return $this->label;    
    }
    
    public function name(string $name): DialogEntry
    {
        $this->name = $name;
        return $this;
    }
    
    public function getName(): string
    {
        return $this->name;        
    }
    
    public function required(bool $value = true): DialogEntry
    {
        $this->required = $value;
        return $this;
    }
    
    public function class(string $class): DialogEntry
    {
        $this->class = $class;
        return $this;
    }
    
    abstract public function getHTMLCode(): string;
}