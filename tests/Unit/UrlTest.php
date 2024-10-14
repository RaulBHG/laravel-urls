<?php

use Src\V1\Domain\Exceptions\BaseException;
use Src\V1\Domain\ShortUrl;
use Src\v1\Domain\ValueObjects\UrlValueObject;
use Tests\TestCase;

uses(TestCase::class);

test('valid URL is accepted', function () {
	$url = 'https://www.example.com';
	$urlValueObject = new UrlValueObject($url);
	expect($urlValueObject->value)->toBe($url);
});

test('invalid URL throws exception', function () {
	$this->expectException(BaseException::class);
	$this->expectExceptionMessage('The url invalid-url is not valid.');
	$this->expectExceptionCode(422);

	$url = 'invalid-url';
	new UrlValueObject($url);
});

test('ShortUrl constructor sets UrlValueObject', function () {
	$url = 'https://www.example.com';
	$urlValueObject = new UrlValueObject($url);
	$shortUrl = new ShortUrl($urlValueObject);

	expect($shortUrl->getUrl())->toBeInstanceOf(UrlValueObject::class);
	expect($shortUrl->getUrl()->value)->toBe($url);
});
