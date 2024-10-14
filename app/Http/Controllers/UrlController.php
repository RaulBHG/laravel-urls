<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShortUrlRequest;
use App\Http\Responses\BasicResponse;
use Src\V1\Infrastructure\UrlController as InfrastructureUrlController;
use Src\V1\Domain\Exceptions\DomainExceptionInterface;

class UrlController extends Controller
{
	public function __construct(private InfrastructureUrlController $infrastructureUrlController)
	{
	}
	public function shortUrl(ShortUrlRequest $request): BasicResponse
	{
		try {
			$url = $this->infrastructureUrlController->shortUrl($request);
			if ($url) {
				return new BasicResponse(
					httpCode: 200,
					response: ['url' => $url],
				);
			} else {
				return new BasicResponse(500, [
					'error' => 'Error creating short url',
				]);
			}
		}
		catch (DomainExceptionInterface $e) {
			return new BasicResponse($e->getCode(), [
				'error' => $e->getMessage(),
			]);
		}

	}

}
