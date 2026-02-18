<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_semester_points', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('semester_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('points')->default(0);
            $table->timestamps();

            $table->unique(['user_id', 'semester_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_semester_points');
    }
};
