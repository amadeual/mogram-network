<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('deposits', function (Blueprint $table) {
            $table->string('gateway')->default('abacatepay')->after('status');
            $table->text('pix_payload')->nullable()->after('gateway');
            $table->text('pix_qr_code')->nullable()->after('pix_payload');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('deposits', function (Blueprint $table) {
            $table->dropColumn(['gateway', 'pix_payload', 'pix_qr_code']);
        });
    }
};
