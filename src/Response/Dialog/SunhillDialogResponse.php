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

    protected $route = '';
    
    protected $route_parameters = [];
    
    protected $method = 'post';
    
    protected $template = 'visual::basic.dialog';
    
    public function setRoute(string $route, array $parameters): SunhillDialog
    {
        $this->route = $route;
        $this->route_parameters = $parameters;
        return $this;
    }
    
    protected function handleFormParameters()
    {
        $this->params['dialog_method'] = $this->method;
        $this->params['dialog_route'] = $this->route;
        $this->params['dialog_route_parameters'] = $this->route_parameters;        
    }
        
    abstract protected function defineDialog(DialogDescriptor $descriptor);
    
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
    
    protected function prepareResponse()
    {
        parent::prepareResponse();
        $this->handleFormParameters();
        $this->handleDialog();
    }
}
