<?php

namespace Src\Infrastructure\Middlewares;

use App\Http\Responses\BasicResponse;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Src\Infrastructure\Repositories\LaravelLogRepository;

class KeycloakRoleMiddleware
{
    public function __construct(private LaravelLogRepository $log)
    {
    }

    public function handle(Request $request, Closure $nextStep, string $roleToCheck): mixed
    {
        try {

            $userRoles = $request->attributes->get('user.roles', "");
            if (!in_array($roleToCheck, $userRoles)) {
                return new BasicResponse(httpCode: 401, data: [], errorMessage: 'Unauthorized');
            }

            return $nextStep($request);

        } catch (Exception $e) {
            $this->log->error($e);
            return new BasicResponse(httpCode: 401, data: [], errorMessage: 'The user cannot be authenticated');
        }
    }

}
