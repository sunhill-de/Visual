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

use Sunhill\InfoMarket\Marketeers\MarketeerBase;
use Sunhill\InfoMarket\Marketeers\Response\Response;
use PhpParser\Node\Expr\Cast\Int_;

use Sunhill\ORM\Facades\Classes;
use Sunhill\ORM\Facades\Objects;
use Sunhill\ORM\Facades\Tags;

class Database extends MarketeerBase
{
    
    /**
     * Returns what items this marketeer offers
     * @return array
     */
    protected function getOffering(): array
    {
        return [
            'database.classes.count'=>'ClassCount',
            'database.classes.root_count'=>'ClassRootCount',
            'database.objects.count'=>'ObjectCount',
            'database.tags.count'=>'TagCount',
        ];
    }
       
    protected function _getClassCount(): Int
    {
        return Classes::getClassCount();    
    }
    
    protected function _getClassRootCount(): Int
    {
        $result = Classes::getClassTree();
        return count($result['object']);
    }
    
    protected function _getObjectCount(): Int
    {
        return Objects::count();
    }
    
    protected function _getTagCount(): Int
    {
        return Tags::getCount();
    }
    
    protected function getClassCount(): Response
    {
        $response = new Response();
        return $response
        ->OK()
        ->update('late')
        ->type('Integer')
        ->unit(' ')
        ->semantic('number')
        ->value($this->_getClassCount());
    }
    
    protected function getClassRootCount(): Response
    {
        $result = new Response();
        return $result
        ->OK()
        ->update('late')
        ->type('Integer')
        ->unit(' ')
        ->semantic('number')
        ->value($this->_getClassRootCount());
    }

    protected function getObjectCount(): Response
    {
        $result = new Response();
        return $result
        ->OK()
        ->update('late')
        ->type('Integer')
        ->unit(' ')
        ->semantic('number')
        ->value($this->_getObjectCount());
    }
    
    protected function getTagCount(): Response
    {
        $result = new Response();
        return $result
        ->OK()
        ->update('late')
        ->type('Integer')
        ->unit(' ')
        ->semantic('number')
        ->value($this->_getTagCount());
    }
    
}
