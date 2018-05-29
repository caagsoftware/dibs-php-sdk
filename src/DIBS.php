<?php

namespace CaagSoftware\DIBSPayment;

use GuzzleHttp\Client;
use CaagSoftware\DIBSPayment\Contracts\HasBodyParams;
use CaagSoftware\DIBSPayment\Requests\Handler;
use CaagSoftware\DIBSPayment\Requests\Request;

class DIBS implements HasBodyParams
{
    public static $currency_mapping = [
        'DKK' => '208', // Danish Kroner
        'EUR' => '978', // Euro
        'USD' => '840', // US Dollar $
        'GBP' => '826', // English Pound £
        'SEK' => '752', // Swedish Kroner
        'AUD' => '036', // Australian Dollar
        'CAD' => '124', // Canadian Dollar
        'ISK' => '352', // Icelandic Kroner
        'JPY' => '392', // Japanese Yen
        'NZD' => '554', // New Zealand Dollar
        'NOK' => '578', // Norwegian Kroner
        'CHF' => '756', // Swiss Franc
        'TRY' => '949', // Turkish Lire
    ];

    /**
     * @var string
     */
    private $merchantId;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $md5key1;

    /**
     * @var string
     */
    private $md5key2;

    /**
     * @var bool
     */
    private $environment = 'production';

    /**
     * @return string
     */
    public function getMerchantId(): string
    {
        return $this->merchantId;
    }

    /**
     * @param string $merchantId
     * @return DIBS
     */
    public function setMerchantId(string $merchantId = null): DIBS
    {
        $this->merchantId = $merchantId;

        return $this;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return DIBS
     */
    public function setUsername(string $username = null): DIBS
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return DIBS
     */
    public function setPassword(string $password = null): DIBS
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return string
     */
    public function getMd5key1(): string
    {
        return $this->md5key1;
    }

    /**
     * @param string $md5key1
     * @return DIBS
     */
    public function setMd5key1(string $md5key1 = null): DIBS
    {
        $this->md5key1 = $md5key1;

        return $this;
    }

    /**
     * @return string
     */
    public function getMd5key2(): string
    {
        return $this->md5key2;
    }

    /**
     * @param string $md5key2
     * @return DIBS
     */
    public function setMd5key2(string $md5key2 = null): DIBS
    {
        $this->md5key2 = $md5key2;

        return $this;
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
