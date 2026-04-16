<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('purchases', function (Blueprint $table) {
            if (!Schema::hasColumn('purchases', 'commission')) {
                $table->decimal('commission', 10, 2)->after('amount')->default(0);
            }
        });

        Schema::table('community_subscriptions', function (Blueprint $table) {
            if (!Schema::hasColumn('community_subscriptions', 'commission')) {
                $table->decimal('commission', 10, 2)->after('amount')->default(0);
            }
        });

        // Add/Update settings
        $settings = [
            ['key' => 'commission_content', 'value' => '15'],
            ['key' => 'commission_community', 'value' => '10'],
            ['key' => 'commission_gifts', 'value' => '20'],
        ];

        foreach ($settings as $setting) {
            DB::table('settings')->updateOrInsert(
                ['key' => $setting['key']],
                ['value' => $setting['value'], 'updated_at' => now(), 'created_at' => now()]
            );
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchases', function (Blueprint $table) {
            $table->dropColumn('commission');
        });

        Schema::table('community_subscriptions', function (Blueprint $table) {
            $table->dropColumn('commission');
        });
    }
};
