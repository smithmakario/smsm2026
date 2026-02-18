<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('semester_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('week_number');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('audio_path')->nullable();
            $table->string('video_url')->nullable();
            $table->string('pdf_path')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->unique(['semester_id', 'week_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('modules');
    }
};
