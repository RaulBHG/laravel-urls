<?php

declare(strict_types=1);

namespace Src\V1\Domain\Contracts;

use Src\v1\Domain\ValueObjects\UrlValueObject;

interface ShortUrlRepositoryContract
{
    public function shortUrl(UrlValueObject $url): ?string;

}
