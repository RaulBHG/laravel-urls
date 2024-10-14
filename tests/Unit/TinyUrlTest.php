<?php

use Illuminate\Support\Facades\Http;
use Src\v1\Domain\ValueObjects\UrlValueObject;
use Src\V1\Infrastructure\Repositories\TinyUrlShortUrlRepository;
use Tests\TestCase;

uses(TestCase::class);

beforeEach(function () {
	$this->repository = new TinyUrlShortUrlRepository();
	$this->testUrl = 'https://www.example.com';
});

test('shortUrl returns short URL on successful HTTP request', function () {
	$url = new UrlValueObject($this->testUrl);
	$shortUrl = 'https://tinyurl.com/example';

	Http::fake([
		config('tinyurl.url') . '*' => Http::response($shortUrl, 200),
	]);

	$result = $this->repository->shortUrl($url);

	expect($result)->toBe($shortUrl);
});

test('shortUrl returns null on unsuccessful HTTP request', function () {
	$url = new UrlValueObject($this->testUrl);

	Http::fake([
		config('tinyurl.url') . '*' => Http::response('Error', 500),
	]);

	$result = $this->repository->shortUrl($url);

	expect($result)->toBeNull();
});

