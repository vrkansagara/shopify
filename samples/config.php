<?php

return [
    'store_name'         => getenv('SHOPIFY_STORE_NAME') ?: null,
    'version'            => getenv('SHOPIFY_VERSION') ?: null,
    'host'               => getenv('SHOPIFY_HOST') ?: null,
    'allowed_basic_auth' => getenv('SHOPIFY_BASIC_AUTH_ENABLE') ?: false,
    'username'           => getenv('SHOPIFY_USERNAME') ?: null,
    'password'           => getenv('SHOPIFY_PASSWORD') ?: null,
];
