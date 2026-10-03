<?php
// app/Exceptions/CategoryHasCoursesException.php
namespace App\Exceptions;

class CategoryHasCoursesException extends BusinessException
{
    protected $message = 'لا يمكن حذف القسم لأنه يحتوي على كورسات';
    protected int $status = 409;
}
