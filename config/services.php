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
    'google' => [
        'client_id' =>"535294813022-npsa4candmofct5g6aiaiv7b0irbhtgu.apps.googleusercontent.com",
        'client_secret' => "IdaB1AdVkAP9bgreunx2gb7x",
        'redirect' => 'http://127.0.0.1:8000/login/google/callback',
    ],
    'facebook' => [
        'client_id' =>"860967254640337",
        'client_secret' => "ca142d1f72b2ad177a57b846665b6dff",
        'redirect' => 'http://127.0.0.1:8000/login/facebook/callback',
    ]
    ,
    'github' => [
        'client_id' => 'c99f35a46a90e6f25e48',
        'client_secret' => '0516eef3d166ffe9365ce59b13f6db672f1d1e2b',
        'redirect' => 'http://127.0.0.1:8000/login/github/callback',
    ]
];
