<?php

namespace Shopify;

use GuzzleHttp\Client as GuzzleHttpClient;
use RuntimeException;

use function getenv;
use function sprintf;

class Shopify
{
    private $config;

    protected $client;

    private $clientOptions;

    public function __construct()
    {
        if (empty($this->config)) {
            $this->config = self::getEnvConfig();
        }
        $this->validateConfig($this->config);

        if (null == $this->client){
            if (null == $this->config) {
                $this->config = self::getEnvConfig();
            }
            $this->validateConfig($this->config);

            if (empty($this->clientOptions)){
                // Set client specific options
                $this->clientOptions = $this->getDefaultOptions();
            }
            $client = new GuzzleHttpClient($this->clientOptions);
            $this->setClient($client);
        }
    }
    protected function getDefaultOptions(): array {
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
        return $this->clientOptions = $options;
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

    protected function validateConfig(array $config)
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

    /**
     * @return mixed
     */
    public function getClientOptions()
    {
        return $this->clientOptions;
    }

    /**
     * @param mixed $clientOptions
     */
    public function setClientOptions($clientOptions): void
    {
        $this->clientOptions = $clientOptions;
    }


    /**
     * @return array
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    /**
     * @param array $config
     */
    public function setConfig(array $config): void
    {
        $this->config = $config;
    }

    /**
     * @return mixed
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param mixed $client
     */
    public function setClient($client): void
    {
        $this->client = $client;
    }


}