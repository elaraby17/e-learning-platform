<?php
// app/Models/Payment.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'user_id',
        'course_id',
        'amount',
        'currency',
        'status',
        'gateway',
        'gateway_order_id',
        'transaction_id',
        'gateway_response',
    ];

    protected $casts = [
        'amount'            => 'decimal:2',
        'gateway_response'  => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
