<?php

namespace Shopify;

use GuzzleHttp\Psr7\Response;

class Order extends Shopify
{
    public function getAll(): Response
    {
        $apiResource = 'orders.json';
        return $this->client->get($apiResource);
    }
}
