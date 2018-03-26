<?php

namespace CaagSoftware\DIBSPayment\Requests;

use GuzzleHttp\Client;
use CaagSoftware\DIBSPayment\DIBS;

class Handler
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
     * @param mixed $client
     */
    public function __construct(DIBS $dibs, $client = null)
    {
        $this->dibs = $dibs;

        $this->guzzle = $client ?: new Client([
            'base_uri' => "https://{$dibs->getMerchantId()}:{$dibs->getMerchantSecret()}@payment.architrade.com",
        ]);
    }

    /**
     * Handle the request.
     *
     * @param Request $request
     *
     * @return array
     */
    public function handle(Request $request): array
    {
        $response = $this->guzzle->request(
            $request->getHttpMethod(),
            $request->getEndpoint(),
            [
                'form_params' => array_merge($this->dibs->toBodyParams(), $request->toBodyParams()),
            ]
        );

        parse_str($response->getBody()->getContents(), $result);

        return [
            'status_code' => (int) $result['result'],
        ];
    }
}
