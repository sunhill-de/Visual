<?php

namespace Sunhill\Visual\Response\Dialog;

abstract class DialogEntry
{
    
    protected $label = '';
    
    protected $name = '';
    
    protected $required = false;
    
    protected $class = null;
    
    protected $value = null;
    
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
    
    public function getDialogName(): string
    {
        return $this->getName();    
    }
    
    public function required(bool $value = true): DialogEntry
    {
        $this->required = $value;
        return $this;
    }
    
    public function getRequired(): bool
    {
        return $this->required;    
    }
    
    public function class(string $class): DialogEntry
    {
        $this->class = $class;
        return $this;
    }
    
    public function getEmptyValue()
    {
        return null;    
    }
    
    public function value($value): DialogEntry
    {
        $this->value = $value;
        return $this;
    }
    
    abstract public function getHTMLCode(): string;
}