<?php

namespace Sunhill\Visual\Response\Crud;

abstract class DialogEntry
{
    
    protected $label = '';
    
    protected $name = '';
    
    protected $groupeditable = false;
    
    protected $required = false;
    
    protected $class = null;
    
    protected $value = null;
        
    public function label($label = ''): DialogEntry
    {
        $this->label = is_null($label)?'':$label;
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
    
    public function groupeditable(bool $value = true): DialogEntry
    {
        $this->groupeditable = $value;
        return $this;
    }
    
    public function getGroupeditable(): bool
    {
        return $this->groupeditable;    
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
    
    public function getValue($value)
    {
        return $value;
    }
    
    public function loadValue(array $values)
    {
        $this->value($values[$this->name]);
    }
    
    abstract public function getHTMLCode(): string;
}