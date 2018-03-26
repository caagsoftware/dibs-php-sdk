<?php

namespace IanRodrigues\DIBSPayment\PaymentHandling;

use IanRodrigues\DIBSPayment\Amount;
use IanRodrigues\DIBSPayment\DIBS;
use IanRodrigues\DIBSPayment\Dispatchable;

class Refund extends Dispatchable
{
    /**
     * @var int
     */
    private $transact;

    /**
     * @var string
     */
    private $orderId;

    /**
     * @var Amount
     */
    private $amount;

    /**
     * Create new Refund instance.
     *
     * @param DIBS   $dibs
     * @param int    $transact
     * @param string $orderId
     * @param Amount $amount
     */
    public function __construct(DIBS $dibs, int $transact, string $orderId, Amount $amount)
    {
        $this->transact = $transact;
        $this->orderId = $orderId;
        $this->amount = $amount;

        parent::__construct($dibs);
    }

    /**
     * @return string
     */
    protected function getHttpMethod(): string
    {
        return 'POST';
    }

    /**
     * @return string
     */
    protected function getEndpoint(): string
    {
        return '/cgi-adm/refund.cgi';
    }

    /**
     * @return array
     */
    public function getBodyParams(): array
    {
        $bodyParams = [
            'transact' => $this->transact,
            'orderid' => $this->orderId,
            'currency' => $this->amount->getCurrency(),
            'amount' => $this->amount->getValue(),
            'textreply' => 'success',
        ];

        return $this->dibs->getBodyParams($bodyParams);
    }
}
