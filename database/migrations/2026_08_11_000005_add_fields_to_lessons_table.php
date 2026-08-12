<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            if (!Schema::hasColumn('lessons', 'transcript')) {
                $table->text('transcript')->nullable();
            }
            if (!Schema::hasColumn('lessons', 'attachment_path')) {
                $table->string('attachment_path')->nullable();
            }
            if (!Schema::hasColumn('lessons', 'quiz_data')) {
                $table->json('quiz_data')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            if (Schema::hasColumn('lessons', 'transcript')) {
                $table->dropColumn('transcript');
            }
            if (Schema::hasColumn('lessons', 'attachment_path')) {
                $table->dropColumn('attachment_path');
            }
            if (Schema::hasColumn('lessons', 'quiz_data')) {
                $table->dropColumn('quiz_data');
            }
        });
    }
};
