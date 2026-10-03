<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'short_description',
        'category_id',
        'instructor_id',
        'status',
        'price',
        'image',
    ];

public function instructor()
{
    return $this->belongsTo(User::class, 'instructor_id');
}

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'enrollments', 'course_id', 'student_id');
    }

    public function sections()
    {
        return $this->hasMany(Section::class)
            ->orderBy('order_number');
    }
}
