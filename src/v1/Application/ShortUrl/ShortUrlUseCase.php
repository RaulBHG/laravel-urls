<?php

namespace Src\V1\Application\ShortUrl;

use Src\V1\Domain\Contracts\ShortUrlRepositoryContract;
use Src\v1\Domain\ValueObjects\UrlValueObject;

final class ShortUrlUseCase
{
    public function __construct(
        private ShortUrlRepositoryContract $repository,
    ) {
    }

    public function shortUrl(string $url): string
    {
		$url = new UrlValueObject(url: $url);
        $shortUrl = $this->repository->shortUrl(url: $url);

        if (!$shortUrl) {
            return '';
        }

        return $shortUrl;
    }
}
