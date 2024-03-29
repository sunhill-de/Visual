<?php

namespace Sunhill\Visual\Tests;

use Sunhill\Basic\SunhillBasicServiceProvider;
use Sunhill\Basic\Tests\SunhillOrchestraTestCase;
use Sunhill\ORM\SunhillServiceProvider;
use Sunhill\Visual\VisualServiceProvider;

class SunhillVisualTestCase extends SunhillOrchestraTestCase
{
    
    public function setUp(): void
    {
        parent::setUp();
    }
    
    protected function getPackageProviders($app)
    {
        return [
            SunhillBasicServiceProvider::class,
            SunhillServiceProvider::class,
            VisualServiceProvider::class
        ];
    }
    
}