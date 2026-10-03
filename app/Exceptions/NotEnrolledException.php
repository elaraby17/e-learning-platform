<?php
// app/Exceptions/NotEnrolledException.php
namespace App\Exceptions;

class NotEnrolledException extends BusinessException
{
    protected $message = 'أنت غير مشترك في هذا الكورس';
    protected int $status = 403;
}
