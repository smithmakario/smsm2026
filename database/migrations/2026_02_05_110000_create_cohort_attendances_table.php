<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cohort_attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cohort_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('week_number');
            $table->string('status'); // present, late, absent
            $table->timestamps();

            $table->unique(['cohort_id', 'user_id', 'week_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cohort_attendances');
    }
};
