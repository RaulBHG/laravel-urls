<?php

namespace Src\Domain\Contracts;

interface OAuth2ValidationsAdapterContract
{
    public function isTokenValid(String $token): bool;

    public function introspectToken(string $token): array;

}
