<?php

namespace IanRodrigues\DIBSPayment;

use GuzzleHttp\Client;

abstract class Dispatchable
{
    /**
     * @var DIBS
     */
    protected $dibs;

    /**
     * @var \GuzzleHttp\Client
     */
    private $guzzle;

    /**
     * @param DIBS $dibs
     */
    public function __construct(DIBS $dibs)
    {
        $this->dibs = $dibs;
        $this->guzzle = new Client([
            'base_uri' => "https://{$dibs->getMerchantId()}:{$dibs->getMerchantSecret()}@payment.architrade.com",
        ]);
    }

    /**
     * @return string
     */
    abstract protected function getHttpMethod(): string;

    /**
     * @return string
     */
    abstract protected function getEndpoint(): string;

    /**
     * @return array
     */
    abstract public function getBodyParams(): array;

    /**
     * Dispatch a function to the DIBS api.
     *
     * @return array
     */
    public function dispatch(): array
    {
        $response = $this->guzzle->request(
            $this->getHttpMethod(),
            $this->getEndpoint(),
            [
                'form_params' => $this->getBodyParams(),
            ]
        );

        parse_str($response->getBody()->getContents(), $result);

        return [
            'status_code' => (int) $result['result'],
        ];
    }
}
