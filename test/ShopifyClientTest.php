<?php

namespace Vrkansagara\ShopifyTest;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Vrkansagara\Shopify\Shopify;

use function Couchbase\defaultDecoder;
use function get_class;

/**
 * - Client must be an object
 * - Client must be the instance of Guzzle Http
 */

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

    public function testClientConfiguratioMustBeAnArray()
    {

       //
    }

    public function testClientCanAcceptArrayAsConfiguration()
    {
        $configuratio = [
            'allow_redirects' => true,
            'exceptions'      => true,
            'decode_content'  => true,
        ];
        $this->shopify->setConfig($configuratio);
        $config = $this->shopify->getConfig();
        $this->assertEquals($configuratio,$config);
    }
}
