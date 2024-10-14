<?php

namespace Src\V1\Domain\Exceptions;

interface DomainExceptionInterface
{
    public function getMessage(): string;

    public function getCode();
}
