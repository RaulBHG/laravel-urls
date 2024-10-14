<?php

namespace Src\V1\Domain;

use Src\v1\Domain\ValueObjects\UrlValueObject;

final class ShortUrl
{

  public function __construct(
    private UrlValueObject $url,
  ) {
  }

  public function getUrl(): UrlValueObject
  {
    return $this->url;
  }

}
