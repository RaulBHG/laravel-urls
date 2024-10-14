<?php

namespace Src\V1\Infrastructure;

use App\Http\Requests\ShortUrlRequest;
use Exception;
use Src\V1\Application\ShortUrl\ShortUrlUseCase;
use Src\V1\Domain\Exceptions\DomainExceptionInterface;
use Src\V1\Infrastructure\Repositories\LaravelLogRepository;
use Src\V1\Infrastructure\Repositories\TinyUrlShortUrlRepository;

final class UrlController
{
	public function __construct(private TinyUrlShortUrlRepository $repository, private LaravelLogRepository $log)
	{
	}

	public function shortUrl(ShortUrlRequest $request): ?string
	{
		try {

			$this->log->info('Enter in ShortUrl.');
			$url = $request->url;
			$useCase = new ShortUrlUseCase(repository: $this->repository);

			return $useCase->shortUrl(url: $url);

		}
		catch (DomainExceptionInterface $e) {
			throw $e;
		}
		catch (Exception $e) {
			$this->log->error($e);

			return null;
		}
	}

}
