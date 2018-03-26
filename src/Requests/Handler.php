<?php

namespace IanRodrigues\DIBSPayment\Requests;

use GuzzleHttp\Client;
use IanRodrigues\DIBSPayment\DIBS;

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
     */
    public function __construct(DIBS $dibs)
    {
        $this->dibs = $dibs;
        $this->guzzle = new Client([
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
        var_dump(array_merge($this->dibs->toBodyParams(), $request->toBodyParams())); die;

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
