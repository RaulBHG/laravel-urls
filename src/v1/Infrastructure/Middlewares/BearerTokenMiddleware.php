<?php

namespace Src\V1\Infrastructure\Middlewares;

use App\Http\Responses\BasicResponse;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Src\V1\Infrastructure\Repositories\LaravelLogRepository;

class BearerTokenMiddleware
{
	public function __construct(
		private LaravelLogRepository $log
	) {}

    public function handle(Request $request, Closure $nextStep): mixed
    {
        try {
            $token = request()->bearerToken();

			// TODO: Hardcoded token
			if($token !== 'testToken123')
				return new BasicResponse(httpCode: 401, response: [
					'error' => 'Unauthorized',
				]);

            return $nextStep($request);
        } catch (Exception $e) {
            $this->log->error($e);
            return new BasicResponse(httpCode: 401, response: [
				'error' => 'Unauthorized',
			]);
        }
    }
}
