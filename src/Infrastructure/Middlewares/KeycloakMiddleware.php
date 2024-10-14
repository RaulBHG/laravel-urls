<?php

namespace Src\Infrastructure\Middlewares;

use App\Http\Responses\BasicResponse;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Src\Infrastructure\Adapters\KeycloakValidationsAdapter;
use Src\Infrastructure\Repositories\LaravelLogRepository;

class KeycloakMiddleware
{
    public function __construct(private KeycloakValidationsAdapter $keycloakValidationsAdapter, private LaravelLogRepository $log)
    {
    }
    public function handle(Request $request, Closure $nextStep): mixed
    {
        try {
            $token = request()->bearerToken();

            $userData = [];
            if(!$token || !$this->keycloakValidationsAdapter->isTokenValid(token: $token, userData: $userData)) {
                return new BasicResponse(httpCode: 401, data: [], errorMessage: 'Unauthorized');
            }

            foreach ($userData as $key => $value) {
                $request->attributes->set($key, $value);
            }

            return $nextStep($request);
        } catch (Exception $e) {
            $this->log->error($e);
            return new BasicResponse(httpCode: 401, data: [], errorMessage: 'The user cannot be authenticated');
        }
    }
}
