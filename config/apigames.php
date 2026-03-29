<?php

return [
    'merchant_id' => env('APIGAMES_MERCHANT_ID'),
    'secret_key'  => env('APIGAMES_SECRET_KEY'),
    'base_url'    => env('APIGAMES_BASE_URL', 'https://v1.apigames.id'),
    
    'endpoints'   => [
        'merchant'  => '/merchant', 
        'transaksi' => '/v2/transaksi', 
    ],
];