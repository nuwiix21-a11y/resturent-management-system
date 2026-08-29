<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$request = Illuminate\Http\Request::create('/api/login', 'POST', [
    'username' => 'nuwixstreet160',
    'password' => '#nuwi0827#'
]);

$response = app()->handle($request);
echo "Admin Login Response:\n";
echo $response->getContent() . "\n\n";

$requestStaff = Illuminate\Http\Request::create('/api/login', 'POST', [
    'username' => 'staff1'
]);

$responseStaff = app()->handle($requestStaff);
echo "Staff Login Response:\n";
echo $responseStaff->getContent() . "\n";
