<?php

namespace Src\Domain\Exceptions;

use Exception;

class BaseException extends Exception implements DomainExceptionInterface
{
    public function __construct($message = 'An unexpected error has occurred.', $code = 400, ?Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
