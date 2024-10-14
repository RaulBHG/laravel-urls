<?php

namespace Src\V1\Infrastructure\Repositories;

use Exception;
use Illuminate\Support\Facades\Log;
use Src\V1\Domain\Contracts\LogRepositoryContract;

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
