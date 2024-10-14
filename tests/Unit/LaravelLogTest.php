<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Src\V1\Infrastructure\Repositories\LaravelLogRepository;

uses(Tests\TestCase::class, RefreshDatabase::class);

test('tests log error method', function () {
    $exception = new Exception('Test exception');
    Log::shouldReceive('error')->once()->with($exception);

    $repository = new LaravelLogRepository();
    $repository->error($exception);
});

test('tests log info method', function () {
    $message = 'Test message';
    Log::shouldReceive('info')->once()->with($message);

    $repository = new LaravelLogRepository();
    $repository->info($message);
});
