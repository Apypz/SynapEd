<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Drop any pre-existing duplicate rows first, otherwise adding the
        // unique index below would fail on databases that already have dupes.
        $duplicateEnrollmentIds = DB::table('enrollments')
            ->select('id')
            ->whereNotIn('id', function ($query) {
                $query->selectRaw('MIN(id)')->from('enrollments')->groupBy('user_id', 'course_id');
            })
            ->pluck('id');
        if ($duplicateEnrollmentIds->isNotEmpty()) {
            DB::table('enrollments')->whereIn('id', $duplicateEnrollmentIds)->delete();
        }

        $duplicateLessonIds = DB::table('lessons')
            ->select('id')
            ->whereNotIn('id', function ($query) {
                $query->selectRaw('MIN(id)')->from('lessons')->groupBy('course_id', 'slug');
            })
            ->pluck('id');
        if ($duplicateLessonIds->isNotEmpty()) {
            DB::table('lessons')->whereIn('id', $duplicateLessonIds)->delete();
        }

        Schema::table('enrollments', function (Blueprint $table) {
            $table->unique(['user_id', 'course_id']);
        });

        Schema::table('lessons', function (Blueprint $table) {
            $table->unique(['course_id', 'slug']);
        });
    }

    public function down(): void
    {
        Schema::table('enrollments', function (Blueprint $table) {
            $table->dropUnique(['user_id', 'course_id']);
        });

        Schema::table('lessons', function (Blueprint $table) {
            $table->dropUnique(['course_id', 'slug']);
        });
    }
};
