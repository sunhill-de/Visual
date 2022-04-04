<?php
/**
 * @file ModuleManager.php
 * Provides the ModuleManager object for handling modules
 * Lang en
 * Reviewstatus: 2022-03-29
 * Localization: unknown
 * Documentation: unknown
 * Tests: unknown
 * Coverage: unknown
 */
namespace Sunhill\Visual\Managers;

/**
 * @author klaus
 *
 */
class ModuleManager 
{
    protected $module_groups = [];
    
    /**
     * Installs a site manager
     */
    public function installSiteManager(string $class)
    {
    }
    
    /**
     * Tries to route the given request in the module system. If successful, it returns a response otherwise false
     * @param $request The given request
     * @return bool|Response If successful, a Response object otherwise false
     */
    public function tryToRoute(Request $request)
    {
                
    }    
}
