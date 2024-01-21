<?php

namespace Sunhill\Visual\Managers;

use Sunhill\ORM\Objects\ORMObject;
use Sunhill\ORM\Facades\Classes;
use Sunhill\ORM\Utils\ObjectList;
use Sunhill\ORM\Properties\PropertyArrayOfObjects;
use Sunhill\ORM\Properties\PropertyObject;

use Sunhill\Visual\Response\Database\Objects\ListObjectsResponse;
use Sunhill\Visual\Response\Database\Objects\AddObjectResponse;
use Illuminate\Support\Facades\Blade;
use Sunhill\Visual\Tests\Unit\DialogManagerResourceTest;

use Sunhill\Visual\Collections\User;
use Sunhill\Visual\Collections\Capability;
use Illuminate\Http\Request;

class UserManager
{

    public function isLoggedIn(): bool
    {
        if (request()->session()->get('user',false)) {
            return true;
        } else {
            return false;
        }
    }
    
    public function getCurrentUser(): string
    {        
        return request()->session()->get('user','nobody');
    }
    
    public function getUserList(): array
    {
        $query = User::query()->get();
        
        return $query->map(function($input) {
           return $input->name; 
        })->toArray();
    }
    
    public function login(string $user, string $password): bool
    {
        $password = md5($password);
        
        if (!($query = User::query()->where('name', $user)->first())) {
            return false;
        }
        if ($query->password !== $password) {
            return false;
        }
        request()->session()->put('user',$user);
        return true;
    }
    
    public function logoff(): bool
    {
        request()->session()->forget('user');
        return true;
    }
    
    public function hasCapability(string $capability): bool
    {
        return true;
    }
    
    public function checkCapability(string $capability)
    {
        if (!$this->hasCapability($capability)) {
            throw new NotAuthorizedException("You are not authorized to execute this.");
        }
    }
}
