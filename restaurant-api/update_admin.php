<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = \App\Models\User::where('role', 'admin')->first();
if ($user) {
    $user->email = 'nuwii0827@gmail.com';
    $user->save();
    echo "Admin email updated.\n";
} else {
    echo "Admin not found.\n";
}
