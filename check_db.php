<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

$tables = ['posts', 'lives', 'communities', 'users', 'purchases', 'withdrawals', 'live_access'];

foreach ($tables as $table) {
    echo "Table: $table\n";
    try {
        $columns = DB::select("DESCRIBE $table");
        foreach ($columns as $column) {
            if (in_array($column->Field, ['price', 'amount', 'balance', 'commission'])) {
                echo "  Column: {$column->Field} | Type: {$column->Type}\n";
            }
        }
    } catch (\Exception $e) {
        echo "  Error: " . $e->getMessage() . "\n";
    }
    echo "\n";
}
