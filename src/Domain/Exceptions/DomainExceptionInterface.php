<?php

namespace Src\Domain\Exceptions;

interface DomainExceptionInterface
{
    public function getMessage(): string;

    public function getCode();
}
