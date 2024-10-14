<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;

class BasicResponse implements Responsable
{
    public function __construct(
        private int $httpCode,
        private array $data = [],
        private string $errorMessage = ''
    ) {
    }

    public function toResponse($request): JsonResponse
    {
        $payload = match (true) {
            ($this->httpCode >= 500) => ['success' => false, 'data' => $this->data, 'error_message' => $this->errorMessage],
            ($this->httpCode >= 400) => ['success' => false, 'data' => $this->data, 'error_message' => $this->errorMessage],
            ($this->httpCode >= 200) => ['success' => true, 'data' => $this->data],
        };

        return response()->json(
            data: $payload,
            status: $this->httpCode,
        );
    }
}
