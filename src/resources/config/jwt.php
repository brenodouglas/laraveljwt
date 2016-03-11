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
        /**
         * Configures the issuer (iss claim)
         */
        'iss' => true,
        /**
         * Configures the audience (aud claim)
         */
        'aud' => true,
        /**
         * Configures the time that the token was issue (iat claim)
         */
        'iat' => true,
        /**
         *  Configures the time that the token can be used (nbf claim)
         */
        'nbf' => false,
        /**
         * Configures the expiration time of the token (exp claim)
         */
        'exp' => true
    ]
];