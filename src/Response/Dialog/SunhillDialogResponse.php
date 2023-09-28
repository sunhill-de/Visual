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
    
    protected $recall = '';
    
    protected $values;
    
    protected $redirect;
    
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
    
    protected function fillFormTemplate(string $route_addition, array $values = [])
    {
        $this->setTemplate('visual::basic.dialog');
        $this->params['dialog_method'] = $this->method;
        $this->params['dialog_route'] = $this->route_base.'.'.$route_addition;
        $this->params['dialog_route_parameters'] = $this->route_parameters;
        
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
            if (array_key_exists($element->name, $values) || array_key_exists('value_'.$element->name, $values)) {
                $entry->loadValue($values);                
            }
            $element->dialog = $entry->getHTMLCode();
            $entries[] = $element;
        }
        $this->params['elements'] = $entries;
    }
    
    protected function addResponse()
    {
        $this->fillFormTemplate('execadd');
    }
    
    protected function parseInput()
    {
        $descriptor = new DialogDescriptor();
        $this->defineDialog($descriptor);
        $result = [];
        foreach ($descriptor as $entry) {
            if (request()->has($entry->getDialogName()) && !empty(request()->input($entry->getDialogName()))) {
                switch ($entry::class) {
                    case DialogEntryList::class:
                        $result[$entry->getName()] = request()->input($entry->getDialogName());
                        $result['name_'.$entry->getName()] = request()->input('name_'.$entry->getDialogName());
                        break;
                    case DialogEntryInputLookup::class:
                        $result['input_'.$entry->getName()] = request()->input('input_'.$entry->getName());
                        $result['value_'.$entry->getName()] = request()->input('value_'.$entry->getName());
                    default:    
                        $result[$entry->getName()] = request()->input($entry->getDialogName());
                }
            } else {
                if ($entry->getRequired()) {
                    $this->inputError($entry, __('This field is required.'));
                }
                $result[$entry->getName()] = $entry->getEmptyValue();                
            }
        }
        $this->input = $result;
        return $result;
    }
    
    protected function inputError($entry, string $message)
    {
        $this->error[$entry->getName()] = $message;
    }
    
    protected function execAddResponse()
    {
        $this->recall = 'execadd';
        $input = $this->parseInput();
        if ($this->error) {
            return;
        }
        if ($this->error = $this->execAdd($input)) {
            return;
        }        
    }
    
    protected function editResponse()
    {
        $this->fillFormTemplate('execedit', $this->getEditValues());
        
    }
    
    protected function execEditResponse()
    {
        $this->recall = 'execedit';
        $input = $this->parseInput();
        if ($this->error) {
            return;
        }
        if ($this->error = $this->execEdit($input)) {
            return;
        }
    }
    
    protected function handleError($values = [])
    {
        $this->fillFormTemplate($this->recall,$values);        
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
            $this->handleError($this->input);
        }
    }
    
    protected function redirect($route)
    {
        $this->redirect = $route;    
    }
    
    protected function getResponse()
    {
        if (!empty($this->redirect)) {
            return redirect(route($this->redirect));   
        }
        return view($this->template, $this->params);
    }
    
}
