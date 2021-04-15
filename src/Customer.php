<?php
declare(strict_types = 1);

/**
* @see       https://github.com/vrkansagara/shopify for the canonical source repository
* @license   https://github.com/vrkansagara/shopify/blob/master/LICENSE.md New BSD License
*/

namespace Vrkansagara\Shopify;

use GuzzleHttp\Psr7\Response;

use function sprintf;

class Customer extends Shopify
{
    /** @var string $resourceKey */
    public $resourceKey = 'customers';

    public function getAll(): Response
    {
        $apiResource = sprintf('%s.json', $this->resourceKey);
        return $this->client->get($apiResource);
    }

    public function get(int $id): Response
    {
        $apiResource = sprintf('%s/%d.json', $this->resourceKey, $id);
        return $this->client->get($apiResource);
    }

    public function delete(int $id): Response
    {
        $apiResource = sprintf('%s/%d.json', $this->resourceKey, $id);
        return $this->client->delete($apiResource);
    }
}
