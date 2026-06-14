<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable = [
        'title',
        'section_id',
        'type',
        'content',
        'video_url',
        'video_duration',
        'is_free_preview',
        'order_number',
    ];
    public function section()
{
    return $this->belongsTo(Section::class);
}
}
