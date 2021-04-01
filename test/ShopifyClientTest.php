<?php

namespace Vrkansagara\ShopifyTest;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Vrkansagara\Shopify\Shopify;

use function get_class;

class ShopifyClientTest extends TestCase
{
    /** @var Shopify $shopify */
    public $shopify;

    protected function setUp(): void
    {
        $this->shopify = new Shopify();
    }

    public function testClientMustBeAnObject()
    {
        $this->assertIsObject($this->shopify);
    }

    public function testClientMustBeAnInstanceofGuzzleHttp()
    {
        $httpClient = new Client();
        $this->assertInstanceOf(get_class($httpClient), $this->shopify->getClient());
    }
}
