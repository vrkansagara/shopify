<?php

namespace Shopify;

use GuzzleHttp\Client;
use RuntimeException;

use function getenv;
use function sprintf;

class Shopify
{
    private $config;

    /** * @var $client Client|null */
    protected $client;

    /**@var $clientOptions array */
    protected $clientOptions = [];

    /**
     * @param null $config
     * @param array $options
     */
    public function __construct($config = null, $options = [], ?Client $client = null)
    {
        // Validate current config
        if ($config) {
            $this->config = $config;
        } else {
            $this->config = self::getEnvConfig();
        }
        $this->validateConfig($this->config);

        // Set client specific options
        $this->clientOptions = $options;

        // Get/Set client
        if (isset($client)) {
            $this->client = $client;
        } else {
            $this->setClient();
        }
    }

    protected function getEnvConfig(): array
    {
        $storeName = getenv('SHOPIFY_STORE_NAME') ?: 'my-dummy-store';
        $host      = getenv('SHOPIFY_HOST') ?: 'myshopify.com';
        $version   = getenv('SHOPIFY_VERSION') ?: '2021-01';
        return [
            'store_name'         => $storeName,
            'version'            => $version,
            'host'               => getenv('SHOPIFY_HOST') ?: $host,
            'allowed_basic_auth' => getenv('SHOPIFY_BASIC_AUTH_ENABLE') ?: false,
            'username'           => getenv('SHOPIFY_USERNAME'),
            'password'           => getenv('SHOPIFY_PASSWORD'),
        ];
    }

    public function validateConfig(array $config)
    {
        $requiredParams = [
            'store_name',
            'host',
            'version',
            'allowed_basic_auth',
        ];
        foreach ($requiredParams as $key) {
            if (! isset($config[$key]) || empty($config[$key])) {
                throw new RuntimeException('Config key missing: ' . $key);
            }
        }
    }

    public function setClient(): self
    {
        $config  = $this->config;
        $baseUrl = sprintf(
            'https://%s.%s/admin/api/%s/',
            $config['store_name'],
            $config['host'],
            $config['version']
        );
        $options = [
            'base_uri' => $baseUrl,
            'headers'  => [
                'Content-Type' => 'application/json',
            ],
        ];

        if ($config['allowed_basic_auth']) {
            $options['auth'] = [$config['username'], $config['password']];
        }
        $this->client = new Client($options);

        return $this;
    }
}
