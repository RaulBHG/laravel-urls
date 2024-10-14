<?php

namespace Src\Infrastructure\Repositories;

use Exception;
use Illuminate\Support\Facades\Log;
use Src\Domain\Contracts\LogRepositoryContract;

final class LaravelLogRepository implements LogRepositoryContract
{
    public function error(Exception $message): void
    {
        Log::error($message);
    }
    public function info(string $message): void
    {
        Log::info($message);
    }
}
