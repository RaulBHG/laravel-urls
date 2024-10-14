<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Src\Infrastructure\Adapters\KeycloakValidationsAdapter;

uses(Tests\TestCase::class, RefreshDatabase::class);

beforeEach(function () {
    $this->adapter = app(KeycloakValidationsAdapter::class);
});

test('verifies if a token is valid', function () {

    Http::fake([
        '*/realms/*/protocol/openid-connect/token/introspect' => Http::response(['token_type' => 'Bearer', 'active' => true, 'sub' => '123', 'realm_access' => ['roles' => ['role1', 'role2']]], 200),
    ]);

    $adapter = app(KeycloakValidationsAdapter::class);
    $result = $adapter->isTokenValid('fakeToken');

    expect($result)->toBeTrue();

});

test('verifies if a token is not valid to return false', function () {

    Http::fake([
        '*/realms/*/protocol/openid-connect/token/introspect' => Http::response(['active' => false], 400),
    ]);

    $this->expectException(Exception::class);

    $this->adapter->isTokenValid('fakeToken');

});

test('introspects a token', function () {

    Http::fake([
        '*/realms/*/protocol/openid-connect/token/introspect' => Http::response(['active' => true, 'sub' => '123', 'realm_access' => ['roles' => ['role1', 'role2']]], 200),
    ]);

    $result = $this->adapter->introspectToken('fakeToken');

    expect($result)->toBeArray();
    expect($result['active'])->toBeTrue();
    expect($result['sub'])->toBe('123');
    expect($result['realm_access']['roles'])->toBe(['role1', 'role2']);

});

test('introspects a token fail', function () {

    Http::fake([
        '*/realms/*/protocol/openid-connect/token/introspect' => Http::response(['active' => false], 400),
    ]);


    $this->expectException(Exception::class);

    $this->adapter->introspectToken('fakeToken');

});
