<?php

declare(strict_types=1);

namespace Src\Domain\Contracts;

use Exception;

interface LogRepositoryContract
{
    public function error(Exception $message): void;
    public function info(string $message): void;
}
