<?php
// app/Exceptions/CannotDeleteSelfException.php
namespace App\Exceptions;

class CannotDeleteSelfException extends BusinessException
{
    protected $message = 'لا يمكنك حذف حسابك الشخصي';
    protected int $status = 403;
}
