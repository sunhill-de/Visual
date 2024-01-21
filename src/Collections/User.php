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
use Sunhill\ORM\Properties\PropertyCollection;

/**
 * The class for an user
 *
 * @author lokal
 *        
 */
class User extends Collection
{
    
    protected static function setupProperties(PropertyList $list)
    {
        $list->varchar('name')
            ->setMaxLen(100)
            ->set_description('The name of the user')
            ->set_displayable(true)
            ->set_editable(true)
            ->set_groupeditable(false)
            ->searchable();
        $list->varchar('password')
            ->setMaxLen(32)
            ->set_description('The password of the user')
            ->set_displayable(true)
            ->set_editable(true)
            ->set_groupeditable(false)
            ->searchable();
        $list->array('capabilities')
             ->setElementType(PropertyCollection::class)
             ->setAllowedClass(Capability::class)
             ->set_description('The capabilities of the user')
             ->set_displayable(true)
             ->set_editable(true)
             ->set_groupeditable(false)
             ->searchable();
    }
    
    protected static function setupInfos()
	{
		static::addInfo('name','User');
		static::addInfo('table','users');
      	static::addInfo('name_s','user',true);
       	static::addInfo('name_p','user',true);
       	static::addInfo('description','Informations about an user', true);
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
