<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('modules', function (Blueprint $table) {
            $table->timestamp('scheduled_start_at')->nullable()->after('published_at');
            $table->timestamp('scheduled_end_at')->nullable()->after('scheduled_start_at');
        });
    }

    public function down(): void
    {
        Schema::table('modules', function (Blueprint $table) {
            $table->dropColumn(['scheduled_start_at', 'scheduled_end_at']);
        });
    }
};
