<?php

namespace App\Providers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }
    public function boot(): void
    {
        Http::macro('withTraceHeaders', function () {
            $request = request();
            $traceId = $request->header('X-B3-TraceId') ?? null;
            $parentSpanId = $request->header('X-B3-SpanId') ?? null;

            return Http::withHeaders([
                'X-B3-TraceId' => $traceId,
                'X-B3-ParentSpanId' => $parentSpanId,
            ]);
        });
    }
}
