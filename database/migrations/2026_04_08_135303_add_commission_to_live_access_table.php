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
        if (Schema::hasTable('live_access')) {
            if (!Schema::hasColumn('live_access', 'commission')) {
                Schema::table('live_access', function (Blueprint $table) {
                    $table->decimal('commission', 10, 2)->default(0)->after('amount');
                });
            }
        } else {
            Schema::create('live_access', function (Blueprint $table) {
                $table->id();
                $table->integer('user_id');
                $table->integer('live_id');
                $table->decimal('amount', 10, 2);
                $table->decimal('commission', 10, 2)->default(0);
                $table->timestamp('created_at')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('live_access', 'commission')) {
            Schema::table('live_access', function (Blueprint $table) {
                $table->dropColumn('commission');
            });
        }
    }
};
