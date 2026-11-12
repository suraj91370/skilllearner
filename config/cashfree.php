<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Cashfree API Credentials
    |--------------------------------------------------------------------------
    | Obtain your App ID and Secret Key from:
    | - Sandbox: https://merchant.cashfree.com/merchants/login (Test Merchant)
    | - Production: https://merchant.cashfree.com/merchants/login
    |
    */
    'app_id' => env('CASHFREE_APP_ID', ''),
    'secret_key' => env('CASHFREE_SECRET_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | Cashfree Environment
    |--------------------------------------------------------------------------
    | Supported: 'sandbox', 'production'
    |
    */
    'env' => env('CASHFREE_ENV', 'sandbox'),

    /*
    |--------------------------------------------------------------------------
    | Cashfree PG API Version
    |--------------------------------------------------------------------------
    | Current stable version: 2023-08-01
    |
    */
    'api_version' => env('CASHFREE_API_VERSION', '2023-08-01'),

    /*
    |--------------------------------------------------------------------------
    | API Base URLs
    |--------------------------------------------------------------------------
    */
    'endpoints' => [
        'sandbox' => 'https://sandbox.cashfree.com/pg',
        'production' => 'https://api.cashfree.com/pg',
    ],
];
