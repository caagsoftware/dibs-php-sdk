<?php

namespace CaagSoftware\DIBSPayment;

use GuzzleHttp\Client;
use CaagSoftware\DIBSPayment\Contracts\HasBodyParams;
use CaagSoftware\DIBSPayment\Requests\Handler;
use CaagSoftware\DIBSPayment\Requests\Request;

class DIBS implements HasBodyParams
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
     * @return array
     */
    public function toBodyParams(): array
    {
        $data = [
            'merchant' => $this->merchantId,
        ];

        if ($this->isTestEnvironment()) {
            $data['test'] = 1;
        } else {
            $data['test'] = 0;
        }

        return $data;
    }

    /**
     * @param Request $request
     * @param mixed $handler
     *
     * @return array
     */
    public function handle(Request $request, $handler = null): array
    {
        $handler = $handler ?: new Handler($this);

        return $handler->handle($request);
    }
}
