<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'instructor_id',
    ];

    public function instructor()
    {
        return $this->belongsTo(User::class , 'instructor_id' , 'id')->where('role', 'instructor');
    }
    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
