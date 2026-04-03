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
        Schema::table('posts', function (Blueprint $table) {
            $table->dateTime('scheduled_at')->nullable()->after('price');
            $table->boolean('allow_comments')->default(true)->after('scheduled_at');
            $table->string('category')->nullable()->after('allow_comments');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn(['scheduled_at', 'allow_comments', 'category']);
        });
    }
};
