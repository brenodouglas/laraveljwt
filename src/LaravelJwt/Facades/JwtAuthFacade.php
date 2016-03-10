<?php
namespace LaravelJwt\Facades;

use Illuminate\Support\Facades\Facade;

class JwtAuthFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'jwtauth';
    }
}