<?php

namespace Vrkansagara\Shopify\Collection;

use GuzzleHttp\Psr7\Response;
use Vrkansagara\Shopify\Shopify;

use function sprintf;

class SmartCollection extends Shopify
{
    /** @var string $resourceKey */
    public $resourceKey = 'smart_collections';

    public function getAll(): Response
    {
        $apiResource = sprintf('%s.json', $this->resourceKey);
        return $this->client->get($apiResource);
    }

    public function delete(int $id): Response
    {
        $apiResource = sprintf('%s/%d.json', $this->resourceKey, $id);
        return $this->client->delete($apiResource);
    }
}
