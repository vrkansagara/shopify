<?php

namespace Shopify;

use GuzzleHttp\Psr7\Response;

class Order extends Shopify
{
	public $resourceKey = 'orders';

    public function getAll(): Response
    {
        $apiResource = sprintf('%s.json',$this->resourceKey);
        return $this->client->get($apiResource);
    }

    public function get(int $id): Response
    {
        $apiResource = sprintf('%s/%d.json',$this->resourceKey,$id);
        return $this->client->get($apiResource);
	}

    public function delete(int $id): Response
    {
        $apiResource = sprintf('%s/%d.json',$this->resourceKey,$id);
        return $this->client->delete($apiResource);
	}

}
