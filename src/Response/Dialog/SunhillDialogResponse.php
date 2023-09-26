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
    
    protected $route = '';
    
    protected $route_parameters = [];
    
    protected $method = 'post';
    
    public function setRoute(string $route, array $parameters): SunhillDialogResponse
    {
        $this->route = $route;
        $this->route_parameters = $parameters;
        return $this;
    }
    
    public function setMode(string $mode): SunhillDialogResponse
    {
        $this->mode = $mode;
        return $this;
    }
    
    protected function handleFormParameters()
    {
        $this->params['dialog_method'] = $this->method;
        $this->params['dialog_route'] = $this->route;
        $this->params['dialog_route_parameters'] = $this->route_parameters;        
    }
        
    abstract protected function defineDialog(DialogDescriptor $descriptor);
    abstract protected function execAdd($parameters);
    
    protected function handleDialog()
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
        $this->handleFormParameters();
        $this->handleDialog();        
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
        
    }
    
    protected function execAddResponse()
    {
        $this->execAdd($this->parseInput());        
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
        }        
    }
}
