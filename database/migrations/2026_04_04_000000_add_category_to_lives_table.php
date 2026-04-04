<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lives', function (Blueprint $table) {
            if (!Schema::hasColumn('lives', 'category')) {
                $table->string('category')->nullable()->default('Geral');
            }
        });
    }

    public function down(): void
    {
        Schema::table('lives', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }
};
