<?php
// app/Exceptions/BusinessException.php
namespace App\Exceptions;

use Exception;

abstract class BusinessException extends Exception
{
    protected int $status = 422;

    public function status(): int
    {
        return $this->status;
    }
}
