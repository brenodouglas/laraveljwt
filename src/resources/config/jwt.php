<?php
/**
 * LaravelJwt - Laravel JWT Package
 * Author: Breno Douglas
 */
return [

    /**
     * Time in seconds expiration Token generate
     */
    'expires' => 3600,

    /**
     * Time in seconds to refresh token after claim jit is create
     */
    'refresh_time' => 3000,

    'not_before_time' => 0,

    /**
     * Host se in issuer JWT
     */
    'host' => 'http://localhost:3000',

    /**
     * Key for sign
     */
    'key' => env('APP_KEY', 'MyKeySignToken!!'),

    'payload' => [
        'iss' => true,
        'aud' => true,
        'iat' => true,
        'nbf' => false,
        'exp' => true
    ]
];