<?php
// app/Exceptions/CourseNotAvailableException.php
namespace App\Exceptions;

class CourseNotAvailableException extends BusinessException
{
    protected $message = 'هذا الكورس غير متاح للاشتراك حالياً';
    protected int $status = 422;
}
