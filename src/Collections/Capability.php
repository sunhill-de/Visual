<?php

/**
 * @file User.php
 * Provides informations about an user
 * Lang en
 * Reviewstatus: 2024-01-21
 * Localization: complete
 * Documentation: unknown
 * Tests: unknown
 * Coverage: unknown
 * Dependencies: ORMObject
 */
namespace Sunhill\Visual\Collections;

use Sunhill\ORM\Objects\Collection;
use Sunhill\ORM\Objects\PropertyList;
use Sunhill\ORM\Properties\PropertyObject;
use Sunhill\ORM\Properties\PropertyVarchar;

/**
 * The class for a capability
 *
 * @author lokal
 *        
 */
class Capability extends Collection
{
    
    protected static function setupProperties(PropertyList $list)
    {
        $list->varchar('name')
            ->setMaxLen(10)
            ->set_description('The name of the capability')
            ->set_displayable(true)
            ->set_editable(true)
            ->set_groupeditable(false)
            ->searchable();
    }
    
    protected static function setupInfos()
	{
		static::addInfo('name','Capability');
		static::addInfo('table','capabilities');
      	static::addInfo('name_s','capability',true);
       	static::addInfo('name_p','capabilities',true);
       	static::addInfo('description','Informations about a capability', true);
       	static::addInfo('options',0);
		static::addInfo('editable',true);
		static::addInfo('instantiable',true);

		static::addInfo('add_capability', 'ADMIN');
		static::addInfo('edit_capability', 'ADMIN');
		static::addInfo('delete_capability', 'ADMIN');
		
		static::addInfo('table_columns',['name']);
		static::addInfo('keyfield',':name');
		
    }
}
