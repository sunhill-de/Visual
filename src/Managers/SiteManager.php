<?php

namespace Sunhill\Visual\Managers;

use Sunhill\ORM\Objects\ORMObject;
use Sunhill\ORM\Facades\Classes;
use Sunhill\ORM\Utils\ObjectList;
use Sunhill\ORM\Properties\PropertyArrayOfObjects;
use Sunhill\ORM\Properties\PropertyObject;

use Sunhill\Visual\Response\Database\Objects\ListObjectsResponse;
use Sunhill\Visual\Response\Database\Objects\AddObjectResponse;
use Sunhill\Visual\Modules\ModuleBase;
use Sunhill\Visual\Entries\EntryBase;

class SiteManager extends \Sunhill\Visual\Modules\SiteManager
{
        protected function getModule(string $name, $module=null)
        {
            if (is_a($module,EntryBase::class)) {
                $module->setName($name);
                return $module;
            } else if (is_null($module)) {
                $result = new ModuleBase();
                $result->setName($name);
                return $result;
            } else {
                throw new \Exception("Can't handle the module");
            }    
        }
    
        public function addMainModule(string $name, $module = null)
        {
            if ($result = $this->findSubEntry($name)) {
                return $result;
            } else {
                $module = $this->getModule($name,$module);
                return $this->addSubEntry($name,$module);
            }
        }
    
        public function addSubModule(string $main_module, string $sub_module_name, $submodule = null)
        {
            if (($module = $this->findSubEntry($main_module)) == false) {
                $module = $this->addMainModule($main_module);
            }
            // $module points to the main module
            return $module->addSubEntry($sub_module_name,$this->getModule($sub_module_name,$submodule));
        }
    
}
