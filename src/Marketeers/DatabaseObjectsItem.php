<?php

namespace Sunhill\Visual\Marketeers;

use Sunhill\InfoMarket\Market\ArrayLeaf;
use Sunhill\ORM\Facades\Objects;

class DatabaseObjectsItem extends ArrayLeaf
{
    protected $element_metadata = [
        'unit'=>'',
        'type'=>'Str',
        'semantic'=>'Branch'
    ];

    protected function getCount(string $filter): int
    {
        return Objects::count();
    }

    protected function getIndexValue(int $index, array $remains, string $order, string $filter)
    {
        return new DatabaseObjectsEntryItem($index);
    }
    
}

