<?php

namespace CaagSoftware\DIBSPayment\Requests\PaymentHandling;

use CaagSoftware\DIBSPayment\Amount;
use CaagSoftware\DIBSPayment\Contracts\HasBodyParams;
use CaagSoftware\DIBSPayment\Requests\Request;

class Refund extends Request implements HasBodyParams
{
    /**
     * @var int
     */
    protected $transact;

    /**
     * @var string
     */
    protected $orderId;

    /**
     * @var Amount
     */
    protected $amount;

    /**
     * Create new Refund instance.
     *
     * @param int    $transact
     * @param string $orderId
     * @param Amount $amount
     */
    public function __construct(int $transact, string $orderId, Amount $amount)
    {
        $this->transact = $transact;
        $this->orderId = $orderId;
        $this->amount = $amount;
    }

    /**
     * @return string
     */
    public function getHttpMethod(): string
    {
        return 'POST';
    }

    /**
     * @return string
     */
    public function getEndpoint(): string
    {
        return '/cgi-adm/refund.cgi';
    }

    /**
     * @return array
     */
    public function toBodyParams(): array
    {
        return [
            'transact' => $this->transact,
            'orderid' => $this->orderId,
            'currency' => $this->amount->getCurrency(),
            'amount' => $this->amount->getValue(),
            'textreply' => 'success',
        ];
    }
}
