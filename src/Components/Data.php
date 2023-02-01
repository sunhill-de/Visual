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
        $result = InfoMarket::getItem($this->name,'anybody','array');
        if (!isset($result['result']) || ($result['result'] == 'OK')) {
            return $result['value'];
        } else {
            return $result['error_code'];
        }
    }
}
