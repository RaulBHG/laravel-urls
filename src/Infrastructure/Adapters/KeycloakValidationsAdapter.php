<?php

namespace Src\Infrastructure\Adapters;

use Exception;
use Illuminate\Support\Facades\Http;
use Src\Domain\Contracts\OAuth2ValidationsAdapterContract;

class KeycloakValidationsAdapter implements OAuth2ValidationsAdapterContract
{
    public function __construct()
    {
    }

    public function isTokenValid(string $token, array &$userData = []): bool
    {
        $tokenData = $this->introspectToken($token);

        $id    = $tokenData['sub'] ?? "";
        $roles = $tokenData['realm_access']['roles'] ?? [];

        $userData = [
            'user.id' => $id,
            'user.roles' => $roles
        ];

        return $tokenData['active']
          && !empty($tokenData['token_type']) && $tokenData['token_type'] === 'Bearer';
    }

    public function introspectToken(string $token): array
    {
        $url      = config('keycloak.base_url');
        $response = Http::withTraceHeaders()->withOptions([
            'verify' => false,
        ])->asForm()
            ->post($url . '/realms/' . config('keycloak.realm') . '/protocol/openid-connect/token/introspect', [
                'token' => $token,
                'client_id' => config('keycloak.service_account_id'),
                'client_secret' => config('keycloak.service_account_secret'),
            ]);

        if ($response->status() !== 200) {
            throw new Exception($response->body());
        }

        return json_decode($response->body(), true);
    }

}
