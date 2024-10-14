<?php

return [
    'base_url' => env(key: 'KEYCLOAK_API_URL', default: 'http://localhost:8080/'),
    'realm' => env(key: 'KEYCLOAK_REALM', default: 'psiconnea'),
    'service_account_id' => env(key: 'KEYCLOAK_SERVICE_ACCOUNT_ID', default: 'your-client-id'),
    'service_account_secret' => env(key: 'KEYCLOAK_SERVICE_ACCOUNT_SECRET', default: ''),

    'test' => [
        'test_user_id' => env(key: 'KEYCLOAK_TEST_USER_ID', default: '')
    ]
];
