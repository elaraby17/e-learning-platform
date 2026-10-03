<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable = [
        'section_id',
        'title',
        'type',
        'content',
        'video_url',
        'video_duration',
        'video_thumbnail',
        'is_free_preview',
        'order_number',
    ];

    protected $casts = [
        'is_free_preview' => 'boolean',
    ];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}
