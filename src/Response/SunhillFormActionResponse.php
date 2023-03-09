<?php

namespace Sunhill\Visual\Response;

class SunhillFormActionResponse extends SunhillRedirectResponse
{
    
    protected $form = '';
    
    protected $action = '';
    
    protected $title = '';
    
    protected function additionalErrorHandling($error)
    {
        
    }
    
    protected function error(string $field,string $message, array $params = [])
    {
        $error = new SunhillBladeResponse();
        $error->setParams([
            'action'=>route($this->action, $params),
            'error_'.$field=>$message,
            'title'=>$this->title]);
        $error->setTemplate($this->form);
        $error->mergeParams($_POST);        
        $this->additionalErrorHandling($error);
        $this->setError($error);
        throw new SunhillResponseException('Invalid field');
    }
    
}