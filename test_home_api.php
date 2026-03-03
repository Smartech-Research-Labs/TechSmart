<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(\Illuminate\Http\Request::create('/api/v1/home', 'GET'));
echo 'Status: ' . $response->getStatusCode() . PHP_EOL;
$data = json_decode($response->getContent(), true);
if ($data) {
    foreach (array_keys($data) as $key) {
        $val = $data[$key];
        if (is_array($val)) {
            echo $key . ': ' . count($val) . ' items' . PHP_EOL;
        } elseif (is_string($val)) {
            echo $key . ': ' . substr($val, 0, 80) . PHP_EOL;
        } else {
            echo $key . ': ' . json_encode($val) . PHP_EOL;
        }
    }
} else {
    echo 'RAW: ' . substr($response->getContent(), 0, 1000) . PHP_EOL;
}
