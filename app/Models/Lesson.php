<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'title',
        'slug',
        'section_title',
        'type',
        'duration',
        'content',
        'video_url',
        'transcript',
        'attachment_path',
        'quiz_data',
        'free',
        'sort_order',
    ];

    protected $casts = [
        'free' => 'boolean',
        'sort_order' => 'integer',
        'quiz_data' => 'array',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
