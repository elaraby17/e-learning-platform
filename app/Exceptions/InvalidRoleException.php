<?php
// app/Exceptions/InvalidRoleException.php
namespace App\Exceptions;

class InvalidRoleException extends BusinessException
{
    protected $message = 'صلاحية المستخدم غير صالحة';
    protected int $status = 403;
}
