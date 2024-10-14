<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;

class BasicResponse implements Responsable
{
    public function __construct(
        private int $httpCode,
        private array $response = [],
    ) {
    }

    public function toResponse($request): JsonResponse
    {
        $payload = match (true) {
            ($this->httpCode >= 500) => $this->response,
            ($this->httpCode >= 400) => $this->response,
            ($this->httpCode >= 200) => $this->response,
        };

        return response()->json(
            data: $payload,
            status: $this->httpCode,
        );
    }
}
