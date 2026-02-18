<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->dateTime('start_at');
            $table->dateTime('end_at')->nullable();
            $table->string('type', 20)->default('free'); // free, paid
            $table->string('format', 20)->default('onsite'); // onsite, virtual
            $table->string('location')->nullable();
            $table->string('meeting_link')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->unsignedInteger('capacity')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
