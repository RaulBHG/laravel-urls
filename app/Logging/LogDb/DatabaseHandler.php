<?php

namespace App\Logging\LogDb;

use App\Models\LogMessage;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\LogRecord;

class DatabaseHandler extends AbstractProcessingHandler
{
    protected function write(LogRecord $record): void
    {
        $request = request();

        $context = json_encode([
            'trace_id' => $request->header('X-B3-TraceId') ?? null,
            'span_id' => $request->header('X-B3-SpanId') ?? null,
        ]);
        $parentId = $request->header('X-B3-ParentSpanId') ?? null;

        $route = $request->path();
        $record['extra']['http.route'] = $route;

        LogMessage::create([
            'name' => config('app.name'),
            'level' => $record['level'],
            'level_name' => $record['level_name'],
            'context' => $context,
            'parent_id' => $parentId,
            'attributes' => json_encode($record['extra']),
            'message' => $record['message'],
            'timestamp' => $record['datetime']->format('Y-m-d H:i:s'),
        ]);
    }
}
