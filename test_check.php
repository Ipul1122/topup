<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Http;

$merchantId = config('apigames.merchant_id');
$secretKey = config('apigames.secret_key');
$baseUrl = config('apigames.base_url');
$signature = md5($merchantId . $secretKey);

$tests = [
    'Test 1: Separate zone_id' => [
        'user_id' => '1030612204',
        'zone_id' => '13124',
        'signature' => $signature,
    ],
    'Test 2: Separate server_id' => [
        'user_id' => '1030612204',
        'server_id' => '13124',
        'signature' => $signature,
    ],
    'Test 3: Separate server' => [
        'user_id' => '1030612204',
        'server' => '13124',
        'signature' => $signature,
    ],
    'Test 4: Separate zone' => [
        'user_id' => '1030612204',
        'zone' => '13124',
        'signature' => $signature,
    ],
    'Test 5: Concatenated user+zone' => [
        'user_id' => '103061220413124',
        'signature' => $signature,
    ],
    'Test 6: Parenthesis user(zone)' => [
        'user_id' => '1030612204(13124)',
        'signature' => $signature,
    ],
];

foreach ($tests as $name => $params) {
    echo "=== {$name} ===\n";
    $endpoint = "{$baseUrl}/merchant/{$merchantId}/cek-username/mobilelegend";
    try {
        $response = Http::get($endpoint, $params);
        echo "URL: " . $response->effectiveUri() . "\n";
        echo "Response: " . $response->body() . "\n\n";
    } catch (\Exception $e) {
        echo "Error: " . $e->getMessage() . "\n\n";
    }
}
