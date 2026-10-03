<?php
// app/Exceptions/InvalidCredentialsException.php
namespace App\Exceptions;

class InvalidCredentialsException extends BusinessException
{
    protected $message = 'البريد الإلكتروني أو كلمة المرور غير صحيحة';
    protected int $status = 401;
}
