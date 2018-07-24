<?php

namespace CaagSoftware\DIBSPayment\Requests;

use GuzzleHttp\Client;
use CaagSoftware\DIBSPayment\DIBS;

class Handler
{
    public static $response_codes = [
        '0' => 'Refund Completed',
        '1' => 'No response from acquirer',
        '2' => 'Timeout',
        '3' => 'Credit card expired',
        '4' => 'Rejected by acquirer',
        '5' => 'Authorisation older than 7 days',
        '6' => 'Transaction status on the DIBS server does not allow function',
        '7' => 'Amount too high',
        '8' => 'Error in the parameters sent to the DIBS server. An additional parameter called "message" is returned, with a value that may help identifying the error',
        '9' => 'Order number (orderid) does not correspond to the authorisation order number',
        '10' => 'Re-authorisation of the transaction was rejected',
        '11' => 'Not able to communicate with the acquier',
        '12' => 'Confirm request error',
        '14' => 'Capture is called for a transaction which is pending for batch - i.e. capture was already called.',
        '15' => 'Capture or refund was blocked by DIBS',
    ];

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
            'base_uri' => "https://{$dibs->getUsername()}:{$dibs->getPassword()}@payment.architrade.com",
        ]);
    }

    /**
     * Handle the request
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

        return $result + ['response_message' => array_get(static::$response_codes, array_get($result, 'reason'))];
    }
}