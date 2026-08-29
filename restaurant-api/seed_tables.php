<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

for ($i = 1; $i <= 25; $i++) {
    \App\Models\Table::create(['table_number' => $i, 'status' => 'available']);
}
echo "Seeded 25 tables.\n";
