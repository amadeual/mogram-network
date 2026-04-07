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
        Schema::table('live_gifts', function (Blueprint $table) {
            $table->foreignId('receiver_id')->nullable()->constrained('users')->after('user_id')->onDelete('cascade');
        });
        
        \Illuminate\Support\Facades\DB::update('UPDATE live_gifts JOIN lives ON live_gifts.live_id = lives.id SET live_gifts.receiver_id = lives.user_id');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('live_gifts', function (Blueprint $table) {
            $table->dropForeign(['receiver_id']);
            $table->dropColumn('receiver_id');
        });
    }
};
