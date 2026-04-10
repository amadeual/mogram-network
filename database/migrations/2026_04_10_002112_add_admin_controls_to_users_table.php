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
        Schema::table('users', function (Blueprint $table) {
            $table->string('status')->default('active')->after('role');
            $table->boolean('withdrawals_frozen')->default(false)->after('status');
            $table->boolean('deposits_frozen')->default(false)->after('withdrawals_frozen');
            $table->string('two_factor_secret')->nullable()->after('deposits_frozen');
            $table->string('country')->nullable()->after('city');
            $table->string('last_ip')->nullable()->after('country');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['status', 'withdrawals_frozen', 'deposits_frozen', 'two_factor_secret', 'country', 'last_ip']);
        });
    }
};
