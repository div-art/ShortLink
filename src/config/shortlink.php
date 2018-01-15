<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default api
    |--------------------------------------------------------------------------
    |
    | Supported: 'google', 'bitly', 'rebrandly'
    |
    */
    'driver' => env('SHORTLINK_DRIVER', 'google'),

    /*
    |--------------------------------------------------------------------------
    | Google api
    |--------------------------------------------------------------------------
    |
    | This is Google shortener api url and key using for aplication.
    |
    */
    'google' => [
        'url' => env('SHORTLINK_GOOGLE_URL', 'https://www.googleapis.com/urlshortener/v1/url'),
        'key' => env('SHORTLINK_GOOGLE_KEY', 'your_google_api_key'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Bitly api
    |--------------------------------------------------------------------------
    |
    | This is Bitly shortener api url and key using for aplication.
    |
    */
    'bitly' => [
        'url' => env('SHORTLINK_BITLY_URL', 'https://api-ssl.bitly.com/v3/shorten'),
        'key' => env('SHORTLINK_BITLY_KEY', 'your_bitly_api_key'),
        'clicks' => env('SHORTLINK_BITLY_CLICKS', 'https://api-ssl.bitly.com/v3/link/clicks'),
        'expand' => env('SHORTLINK_BITLY_CLICKS', 'https://api-ssl.bitly.com/v3/expand'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Rebrandly api
    |--------------------------------------------------------------------------
    |
    | This is Rebrandly shortener api url and key using for aplication.
    |
    */
    'rebrandly' => [
        'url' => env('SHORTLINK_REBRANDLY_URL', 'https://api.rebrandly.com/v1/links'),
        'key' => env('SHORTLINK_REBRANDLY_KEY', '7958a3c2e3714b429c58b69dd7ea77b3'),
    ],


];