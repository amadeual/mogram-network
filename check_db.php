<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$gifts = \App\Models\Gift::all();
foreach ($gifts as $gift) {
    echo "ID: $gift->id, Name: $gift->name, Price: $gift->price\n";
}
