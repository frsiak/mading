<?php

// Simple test script to debug login issues
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Create a test request
$request = Illuminate\Http\Request::create('/login', 'POST', [
    'username' => 'siswa1',
    'password' => 'siswa123',
    '_token' => csrf_token()
]);

try {
    $response = $kernel->handle($request);
    echo "Response Status: " . $response->getStatusCode() . "\n";
    echo "Response Headers: " . json_encode($response->headers->all()) . "\n";
    
    if ($response->isRedirect()) {
        echo "Redirect to: " . $response->headers->get('Location') . "\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}

$kernel->terminate($request, $response);