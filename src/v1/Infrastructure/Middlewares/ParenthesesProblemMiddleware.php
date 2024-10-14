<?php

namespace Src\V1\Infrastructure\Middlewares;

use App\Http\Responses\BasicResponse;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Src\v1\Infrastructure\Services\ParenthesesProblemService;

class ParenthesesProblemMiddleware
{
	public function __construct(
		private ParenthesesProblemService $parenthesesProblemService
	) {}

    public function handle(Request $request, Closure $nextStep): mixed
    {
        try {
            $token = request()->bearerToken();
			if($token === null){
				return new BasicResponse(httpCode: 401, response: [
					'error' => 'Unauthorized',
				]);
			}
			$passTest = $this->parenthesesProblemService->solveParenthesesProblem($token);
			if(!$passTest){
				return new BasicResponse(httpCode: 401, response: [
					'error' => 'Unauthorized',
				]);
			}

            return $nextStep($request);
        } catch (Exception $e) {
            Log::error($e);
            return new BasicResponse(httpCode: 401, response: [
				'error' => 'Unauthorized',
			]);
        }
    }




}
