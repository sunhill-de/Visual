<?php

namespace Sunhill\Visual\Marketeers;

use Sunhill\InfoMarket\Market\ArrayLeaf;
use Sunhill\ORM\Facades\Classes;

class DatabaseClassesItem extends ArrayLeaf
{
    protected $element_metadata = [
        'unit'=>'',
        'type'=>'Str',
        'semantic'=>'Branch'
    ];

    protected function getCount(string $filter): int
    {
        return Classes::getClassCount();
    }

    protected function getIndexValue(int $index, array $remains, string $order, string $filter)
    {
        return new DatabaseClassesEntryItem($index);
    }
    
}

