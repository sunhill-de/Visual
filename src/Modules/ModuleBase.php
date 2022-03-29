<?php

namespace Sunhill\Visual\Modules;

/**
 * A basic class for differnt kinds of modules
 * @author lokal
 *
 */
class ModuleBase
{
    
    protected $name;
    
    public function __construct(string $name)
    {
        $this->name = $name;
    }
}