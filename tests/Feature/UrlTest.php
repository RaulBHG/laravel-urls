<?php

use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Osteel\OpenApi\Testing\ValidatorBuilder;

uses(RefreshDatabase::class, WithoutMiddleware::class);

beforeEach(function () {
	$this->faker = Factory::create();
});

test('short url success test', function () {
	$url = $this->faker->url;
	$response = $this->post('/api/v1/short-urls', ['url' => $url]);
	$validator = ValidatorBuilder::fromYamlFile('api_definition.yml')->getValidator();
	$result = $validator->validate($response->baseResponse, '/api/v1/short-urls', 'post');

	expect($result)->toBeTrue();
	expect($response->getStatusCode())->toBe(200);
});

test('short url fail test', function () {
	$url = $this->faker->word;
	$response = $this->post('/api/v1/short-urls', ['url' => $url]);
	$validator = ValidatorBuilder::fromYamlFile('api_definition.yml')->getValidator();
	$result = $validator->validate($response->baseResponse, '/api/v1/short-urls', 'post');

	expect($result)->toBeTrue();
	expect($response->getStatusCode())->toBe(422);
});
