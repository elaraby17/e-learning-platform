<?php
// app/Exceptions/AlreadyEnrolledException.php
namespace App\Exceptions;

class AlreadyEnrolledException extends BusinessException
{
    protected $message = 'أنت مشترك بالفعل في هذا الكورس';
    protected int $status = 409;
}
