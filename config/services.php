<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */
    'facebook' => [
        'client_id' => '2541425469470862',  // Your Facebook App ID
        'client_secret' => '631c9995a04dc8981aa9543a99c65133', // Your Facebook App Secret
        'redirect' => 'http://localhost:8000/login/facebook/callback',
    ],

    'google' => [
        'client_id' => '500564591191-vcvu4nodvnca5c7nq6tr21fq2hhb0e11.apps.googleusercontent.com',
        'client_secret' => 'FTiJAbCehKbdVWRIcDHDsG0Z',
        'redirect' => 'http://localhost:8000/login/google/callback',
    ],

    // 'twitter' => [
    //     'client_id' => '2541425469470862',  // Your Facebook App ID
    //     'client_secret' => '5126517407mshdc8955942d1a45ep1c9a68jsnc914549c1d5a', // Your Facebook App Secret
    //     'redirect' => 'http://localhost:8000/login/facebook/callback',
    // ],

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

];
