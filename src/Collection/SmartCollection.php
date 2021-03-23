<?php

namespace Shopify\Collection;

use GuzzleHttp\Psr7\Response;
use Shopify\Shopify;

class SmartCollection extends Shopify
{
	public $resourceKey = 'smart_collections';

    public function getAll(): Response
    {
        $apiResource = sprintf('%s.json',$this->resourceKey);
        return $this->client->get($apiResource);
    }

    public function delete(int $id): Response
    {
        $apiResource = sprintf('%s/%d.json',$this->resourceKey,$id);
        return $this->client->delete($apiResource);
	}

}
