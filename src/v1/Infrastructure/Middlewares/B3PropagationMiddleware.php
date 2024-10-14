<?php

namespace Src\V1\Infrastructure\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class B3PropagationMiddleware
{
    public function handle(Request $request, Closure $nextStep): mixed
    {
        $this->setHeaders(request: $request);

        return $nextStep($request);
    }

    private function setHeaders(Request $request): void
    {
        $traceId = $request->header('X-B3-TraceId') ?? null;
        $parentSpanId = $request->header('X-B3-ParentSpanId') ?? null;

        if (!$traceId) {
            $uuid128 = Str::uuid()->toString();
            $hash128 = substr(hash('sha256', $uuid128), 0, 32);
            $traceId128Bit = $hash128;
            $request->headers->set('X-B3-TraceId', $traceId128Bit);
        }
        if (!$parentSpanId) {
            $request->headers->set('X-B3-ParentSpanId', $parentSpanId);
        }

        $uuid64 = Str::uuid()->toString();
        $hash64 = substr(hash('sha256', $uuid64), 0, 16);
        $spanId64Bit = $hash64;
        $request->headers->set('X-B3-SpanId', $spanId64Bit);
    }

}
