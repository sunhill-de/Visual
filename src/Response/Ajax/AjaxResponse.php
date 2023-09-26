<?php

namespace Sunhill\Visual\Response\Ajax;

abstract class AjaxResponse
{
    
    protected $parameter1 = '';
    
    protected $parameter2 = '';
    
    /**
     * Returns the answer of this module to the ajax controller. It doesn't have to be a json answer
     * this will be created by the ajax controller.
     * @param string $parameter1
     * @param string $parameter2
     * @return unknown
     */
    public function getOutput(string $parameter1, string $parameter2)
    {
        $search = request()->input('search','');
        $this->parameter1 = $parameter1;
        $this->parameter2 = $parameter2;
        
        return $this->assembleOutput($search);
    }
    
    /**
     * Helper function that creates a stdclass from a given array
     * @param array $input
     * @return \StdClass
     */
    protected function makeStdclass(array $input): \StdClass
    {
        $result = new \StdClass();
        foreach ($input as $key => $value) {
            $result->$key = $value;
        }
        return $result;
    }

    /**
     * This method has to be overwritten by the inhertied class. It returns the answer to the given 
     * search request.
     * @param string $search
     */
    abstract protected function assembleOutput(string $search);
}