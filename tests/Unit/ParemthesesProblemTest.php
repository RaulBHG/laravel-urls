<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Src\V1\Infrastructure\Repositories\LaravelLogRepository;
use Src\v1\Infrastructure\Services\ParenthesesProblemService;

uses(Tests\TestCase::class, RefreshDatabase::class);

beforeEach(function () {
	$this->service = new ParenthesesProblemService();
	$this->testUrl = 'https://www.example.com';
});

test('tests valid tokens method', function () {
	$tokens = [
		'()',
		'{}',
		'[]',
		'({})',
		'{()}',
		'{}{}[]()()[]',
	];

	foreach ($tokens as $token) {
		expect($this->service->solveParenthesesProblem($token))->toBeTrue();
	}
});

test('tests not valid tokens method', function () {
	$tokens = [
		'[(]',
        '(',
        ')',
        '{',
        '}',
        '[',
        ']',
        'a({)}',
        '{}{]()()[]}',
        '(((((((()',
        '(((()',
        '([)]'
	];

	foreach ($tokens as $token) {
		expect($this->service->solveParenthesesProblem($token))->toBeFalse();
	}
});
