<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('slug')->unique();
            $table->string('title');
            $table->text('short_desc')->nullable();
            $table->text('long_desc')->nullable();
            $table->string('category')->default('neuroscience');
            $table->string('level')->default('Pemula');
            $table->string('level_color')->default('green');
            $table->decimal('price', 12, 2)->default(0);
            $table->string('duration')->default('6 Jam');
            $table->string('icon')->default('brain');
            $table->float('rating')->default(4.8);
            $table->integer('reviews_count')->default(0);
            $table->string('instructor')->nullable();
            $table->string('instructor_bio')->nullable();
            $table->json('what_you_learn')->nullable();
            $table->json('requirements')->nullable();
            $table->string('thumbnail')->nullable();
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
