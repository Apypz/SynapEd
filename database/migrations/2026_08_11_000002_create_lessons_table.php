<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete();
            $table->string('title');
            $table->string('slug');
            $table->string('section_title')->default('Modul Utama');
            $table->string('type')->default('video'); // video, reading, quiz
            $table->string('duration')->default('15 menit');
            $table->text('content')->nullable();
            $table->string('video_url')->nullable();
            $table->text('transcript')->nullable();
            $table->string('attachment_path')->nullable();
            $table->json('quiz_data')->nullable();
            $table->boolean('free')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
