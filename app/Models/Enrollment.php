<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
  protected $fillable = [
    'student_id',
    'course_id',
    'progress_percentage',
    'price',
    'status',
    'enrolled_at',
];

protected $casts = [
    'progress_percentage' => 'decimal:2',
    'price' => 'decimal:2',
    'enrolled_at' => 'datetime',
];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }



    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
