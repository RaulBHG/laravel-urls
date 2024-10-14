<?php

declare(strict_types=1);

namespace Src\V1\Infrastructure\Repositories;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Src\V1\Domain\Contracts\ShortUrlRepositoryContract;
use Src\v1\Domain\ValueObjects\UrlValueObject;

class TinyUrlShortUrlRepository implements ShortUrlRepositoryContract
{

	public function shortUrl(UrlValueObject $url): ?string
	{
		try {
			$tinyUrl = config('tinyurl.url') . $url->value;
			$response = Http::get($tinyUrl);
			if ($response->successful()) {
				return $response->body();
			}else{
				Log::error('Error creating short url', ['error' => $response->body()]);
				return null;
			}
		} catch (Exception $e) {
			Log::error('Error creating short url', ['error' => $e->getMessage()]);
			return null;
		}
	}
}
