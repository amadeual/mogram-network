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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // Seed default settings
        DB::table('settings')->insert([
            ['key' => 'commission_percentage', 'value' => '15', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'withdrawal_fee', 'value' => '5.00', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'site_name', 'value' => 'Mogram', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'currency', 'value' => 'R$', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
