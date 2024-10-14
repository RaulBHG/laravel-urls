<?php

namespace Src\v1\Domain\ValueObjects;

use Src\V1\Domain\Exceptions\BaseException;

class UrlValueObject
{
	public $value;

	public function __construct(string $url)
	{
		$this->value = self::validate($url);
	}

	public static function validate(string $url): string
	{
		if (!filter_var($url, FILTER_VALIDATE_URL)) {
			throw new BaseException(message: 'The url ' . $url . ' is not valid.', code: 422);
		}
		return $url;
	}
}
