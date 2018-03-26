<?php

namespace IanRodrigues\DIBSPayment;

use GuzzleHttp\Client;
use IanRodrigues\DIBSPayment\Contracts\Dispatchable;

class DIBS
{
    /**
     * @var string
     */
    private $merchantId;

    /**
     * @var string
     */
    private $merchantSecret;

    /**
     * @var bool
     */
    private $environment = 'production';

    /**
     * @param string $merchantId
     * @param string $merchantSecret
     */
    public function __construct(string $merchantId, string $merchantSecret)
    {
        $this->merchantId = $merchantId;
        $this->merchantSecret = $merchantSecret;
    }

    /**
     * @return string
     */
    public function getMerchantId(): string
    {
        return $this->merchantId;
    }

    /**
     * @return string
     */
    public function getMerchantSecret(): string
    {
        return $this->merchantSecret;
    }

    /**
     * @return void
     */
    public function setTestEnvironment(): void
    {
        $this->environment = 'test';
    }

    /**
     * @return bool
     */
    public function isTestEnvironment(): bool
    {
        return $this->environment === 'test';
    }

    /**
     * @param  array  $append
     * @return array
     */
    public function getBodyParams(array $append = []): array
    {
        $bodyParams = array_merge([
            'merchant' => $this->merchantId,
        ], $append);

        if ($this->isTestEnvironment()) {
            $bodyParams['test'] = 1;
        }

        return $bodyParams;
    }
}
