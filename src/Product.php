<?php

namespace Shopify;

use GuzzleHttp\Psr7\Response;

class Product extends Shopify
{
    public function getAll(): Response
    {
        $apiResource = 'products.json';
        return $this->client->get($apiResource);
    }
}
