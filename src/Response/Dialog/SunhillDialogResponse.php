<?php

/**
 * @file SunhillListResponse
 * Basic class that return blade templates
 *
 */
namespace Sunhill\Visual\Response\Dialog;

use Sunhill\Visual\Response\SunhillBladeResponse;

abstract class SunhillDialogResponse extends SunhillBladeResponse
{

    protected $mode = 'add';
    
    protected $route_base = '';
    
    protected $route_parameters = [];
    
    protected $method = 'post';
    
    protected $error = [];
    
    public function setRoute(string $route_base, array $parameters): SunhillDialogResponse
    {
        $this->route_base       = $route;
        $this->route_parameters = $parameters;
        return $this;
    }
    
    public function setMode(string $mode): SunhillDialogResponse
    {
        $this->mode = $mode;
        return $this;
    }
    
        
    abstract protected function defineDialog(DialogDescriptor $descriptor);
    abstract protected function execAdd($parameters);
    abstract protected function getEditValues();
    abstract protected function execEdit($parameters);
    
    protected function handleAddFormParameters()
    {
        $this->params['dialog_method'] = $this->method;
        $this->params['dialog_route'] = $this->route_base.'.execadd';
        $this->params['dialog_route_parameters'] = $this->route_parameters;
    }
    protected function handleAddDialog()
    {
        $descriptor = new DialogDescriptor();
        $this->defineDialog($descriptor);
        $entries = [];
        foreach ($descriptor as $entry) {
            $element = new \StdClass();
            $element->label = $entry->getLabel();
            $element->name = $entry->getName();
            $element->dialog = $entry->getHTMLCode();
            $entries[] = $element;
        }
        $this->params['elements'] = $entries;
    }
    
    protected function addResponse()
    {
        $this->setTemplate('visual::basic.dialog');
        $this->handleAddFormParameters();
        $this->handleAddDialog();        
    }
    
    protected function parseInput()
    {
        $descriptor = new DialogDescriptor();
        $this->defineDialog($descriptor);
        $result = [];
        foreach ($descriptor as $entry) {
            if (request()->has($entry->getDialogName()) && !empty(request()->input($entry->getDialogName()))) {
                $result[$entry->getName()] = request()->input($entry->getDialogName());
            } else {
                if ($entry->getRequired()) {
                    $this->inputError($entry, __('This field is required.'));
                }
                $result[$entry->getName()] = $entry->getEmptyValue();                
            }
        }
        return $result;
    }
    
    protected function inputError($entry, string $message)
    {
        $this->error[$entry->getName()] = $message;
    }
    
    protected function execAddResponse()
    {
        $this->execAdd($this->parseInput());        
    }
    
    protected function editResponse()
    {
        
    }
    
    protected function execEditResponse()
    {
        
    }
    
    protected function handleError()
    {
        $this->params['dialog_method'] = $this->method;
        $this->params['dialog_route'] = $this->route_base.'.execadd';
        $this->params['dialog_route_parameters'] = $this->route_parameters;
        $this->setTemplate('visual::basic.dialog');
        
        $descriptor = new DialogDescriptor();
        $this->defineDialog($descriptor);
        $entries = [];
        foreach ($descriptor as $entry) {
            $element = new \StdClass();
            $element->label = $entry->getLabel();
            $element->name = $entry->getName();
            if (array_key_exists($element->name,$this->error)) {
                $element->error = $this->error[$element->name];
            }
            $element->value = $entry->getValue(request()->input($entry->getName()));
            $entry->value($element->value);
            $element->dialog = $entry->getHTMLCode();
            $entries[] = $element;
        }
        $this->params['elements'] = $entries;
        
    }
    
    protected function prepareResponse()
    {
        parent::prepareResponse();
        switch ($this->mode) {
            case 'add':
                $this->addResponse();
                break;
            case 'execadd':
                $this->execAddResponse();
                break;
            case 'edit':
                $this->editResponse();
                break;
            case 'execedit':
                $this->execEditResponse();
                break;
        }
        if (!empty($this->error)) {
            $this->handleError();
        }
    }
}
