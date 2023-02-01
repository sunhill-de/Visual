<?php
/**
 * @file CPU.php
 * Provides information about the cpu
 * Lang en
 * Reviewstatus: 2021-10-30
 * Localization: none
 * Documentation: complete
 * Tests:
 * Coverage: unknown
 * Dependencies: none
 * PSR-State: complete
 */

namespace Sunhill\Visual\Marketeers;

use Sunhill\InfoMarket\Market\Marketeer;

class Database extends Marketeer
{
    
    protected function getOffering(): array
    {
        return [
   //         'database.classes'=>DatabaseClassesItem::class,
            'database.objects'=>DatabaseObjectsItem::class,
        ];
    }
    
    
}
