<?php

return [
    'store_name'         => getenv('SHOPIFY_STORE_NAME') ?: 'my-dummy-store',
    'version'            => getenv('SHOPIFY_VERSION') ?: '2021-01',
    'host'               => getenv('SHOPIFY_HOST') ?: 'myshopify.com',
    'allowed_basic_auth' => getenv('SHOPIFY_BASIC_AUTH_ENABLE') ?: false,
    'username'           => getenv('SHOPIFY_USERNAME') ?: '',
    'password'           => getenv('SHOPIFY_PASSWORD') ?: '',
];
