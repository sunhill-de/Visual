<?php

namespace Sunhill\Visual\Components;

use Illuminate\View\Component;
use Sunhill\ORM\Facades\Classes;
use Sunhill\ORM\Facades\Objects;
use Sunhill\Visual\Facades\Dialogs;
use Sunhill\InfoMarket\Facades\InfoMarket;

class Data extends Component
{
    
    protected $name;
    
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $result = json_decode(InfoMarket::readItem($this->name),true);
        if ($result['result'] == 'OK') {
            return $result['value'];
        } else {
            return $result['error_code'];
        }
    }
}
