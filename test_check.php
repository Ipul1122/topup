<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Services\DigiflazzService;

$digiflazzService = new DigiflazzService();

echo "=== Test 1: Get Merchant Info (Cek Saldo) ===\n";
$info = $digiflazzService->getMerchantInfo();
print_r($info);
echo "\n";

echo "=== Test 2: Check Username Mock ===\n";
$usernameCheck = $digiflazzService->checkUsername('mobilelegend', '12345678');
print_r($usernameCheck);
echo "\n";

echo "=== Test 3: Get Products Price List (Top 3 Items) ===\n";
$products = $digiflazzService->getProducts();
if (isset($products['data'])) {
    $slice = array_slice($products['data'], 0, 3);
    print_r($slice);
} else {
    print_r($products);
}
echo "\n";
