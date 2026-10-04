<?php

namespace App\Exceptions;

class AccountDisabledException extends BusinessException
{
    protected $message = 'حسابك معطل، تواصل مع الإدارة';
    protected int $status = 403;
}
