<?php

namespace Sunhill\Visual\Components;

use Illuminate\View\Component;
use Sunhill\ORM\Facades\Classes;
use Sunhill\ORM\Facades\Objects;
use Sunhill\Visual\Facades\Dialogs;
use Sunhill\ORM\Facades\InfoMarket;

class Status extends Component
{
    
    protected $name;
    
    protected $description = '';

    protected $success_message = '';
    
    protected $error_message = '';
    
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $description, $success_message = '', $error_message = '')
    {
        $this->name = $name;
        $this->description = $description;
        $this->success_message = $success_message;
        $this->error_message = $error_message;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $result = InfoMarket::getItem($this->name.'.status','anybody','array');
        if ($result) {
            $color = 'green';
            if (!empty($this->success_message)) {
                $message = InfoMarket::getItem($this->name.'.'.$this->success_message,'anybody','array');
            }
        } else {
            $color_response = InfoMarket::getItem($this->name.'.severity', 'anybody', 'array');
            if (!isset($result['result']) || ($result['result'] == 'OK')) {
                $color = 'red';
            } else {
                $color = $color_response['value'];
            }
            if (!empty($this->success_message)) {
                $message = InfoMarket::getItem($this->name.'.'.$this->success_message,'anybody','array');
            }            
        }
        
        return view('visual::components.status', ['severity'=>$color, 'description'=>$this->description]);
    }
}
