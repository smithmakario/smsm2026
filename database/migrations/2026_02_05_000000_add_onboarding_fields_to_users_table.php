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
            $table->string('marital_status', 50)->nullable()->after('user_type');
            $table->string('occupation')->nullable()->after('marital_status');
            $table->string('occupation_category', 100)->nullable()->after('occupation');
            $table->string('church')->nullable()->after('occupation_category');
            $table->string('country', 100)->nullable()->after('church');
            $table->string('state', 100)->nullable()->after('country');
            $table->string('city', 100)->nullable()->after('state');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'marital_status',
                'occupation',
                'occupation_category',
                'church',
                'country',
                'state',
                'city',
            ]);
        });
    }
};
