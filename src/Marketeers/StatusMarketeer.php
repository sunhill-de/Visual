<?php

namespace Sunhill\Visual\Marketeers;

use Sunhill\ORM\InfoMarket\OnDemandMarketeer;
use Sunhill\ORM\InfoMarket\Items\DynamicItem;

abstract class StatusMarketeer extends OnDemandMarketeer
{
    
    abstract protected function getStatus(): bool;
    
    protected function getSeverity(): string
    {
        return 'red';    
    }

    protected function getMessage(): string
    {
        return '';    
    }
    
    protected function requestTerminalItem(string $name)
    {
        switch ($name) {
            case 'status':
                $result = $this->createResponseFromValue($this->getStatus());
                return $result->OK()->type('bool')->unit('None')->semantic('Status')->readable()->writeable(false)->update('asap');
                break;
            case 'severity':
                $result = $this->createResponseFromValue($this->getSeverity());
                return $result->OK()->type('string')->unit('None')->semantic('Status')->readable()->writeable(false)->update('asap');
                break;
            case 'message':
                $result = $this->createResponseFromValue($this->getMessage());
                return $result->OK()->type('string')->unit('None')->semantic('Status')->readable()->writeable(false)->update('asap');
                break;
            default:
                return null;
        }
    }
    
    protected function initializeMarketeer()
    {
        $this->addEntry('status',   (new DynamicItem())->defineValue($this->getStatus())->type('boolean')->semantic('Status'));
        $this->addEntry('severity', (new DynamicItem())->defineValue($this->getSevertity())->type('string')->semantic('name'));
        $this->addEntry('message',  (new DynamicItem())->defineValue($this->getMessage())->type('string')->semantic('name'));
    }
    
}