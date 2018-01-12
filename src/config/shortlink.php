<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default api
    |--------------------------------------------------------------------------
    |
    | Supported: 'google', 'bitly'
    |
    */
    'default_api' => env('DEFAULT_SHORTLINK_API', 'google'),

    /*
    |--------------------------------------------------------------------------
    | Google api URL
    |--------------------------------------------------------------------------
    |
    | This is google shortener api url using for aplication.
    |
    */
    'google_api_url' => env('SHORTLINK_GOOGLE_URL', 'your_google_api_url'),

    /*
    |--------------------------------------------------------------------------
    | Google api key
    |--------------------------------------------------------------------------
    |
    | This is google shortener api key using for aplication.
    |
    */
    'google_api_key' => env('SHORTLINK_GOOGLE_KEY', 'your_google_api_key'),

    /*
    |--------------------------------------------------------------------------
    | Bitly api URL
    |--------------------------------------------------------------------------
    |
    | This is bitly shortener api url using for aplication.
    |
    */
    'bitly_api_url' => env('SHORTLINK_BITLY_URL', 'your_bitly_api_url'),

    /*
    |--------------------------------------------------------------------------
    | Bitly api key
    |--------------------------------------------------------------------------
    |
    | This is bitly shortener api key using for aplication.
    |
    */
    'bitly_api_key' => env('SHORTLINK_BITLY_KEY', 'your_bitly_api_key'),

];