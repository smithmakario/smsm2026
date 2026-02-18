<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mentee_semester_projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('semester_project_id')->constrained()->cascadeOnDelete();
            $table->string('status')->default('not_started');
            $table->timestamp('selected_at')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'semester_project_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mentee_semester_projects');
    }
};
