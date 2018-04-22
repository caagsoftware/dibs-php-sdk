<?php

namespace CaagSoftware\DIBSPayment\Flexwin;

use CaagSoftware\DIBSPayment\Amount;
use CaagSoftware\DIBSPayment\Contracts\HasBodyParams;

class Transaction implements HasBodyParams
{
    /**
     * @var string
     */
    private $orderId;

    /**
     * @var Amount
     */
    private $amount;

    /**
     * @var string
     */
    private $acceptUrl;

    /**
     * @var bool
     */
    private $captureNow = false;

    /**
     * @var string
     */
    private $language;

    /**
     * Create new Transaction instance.
     *
     * @param DIBS $dibs
     * @param string $orderId
     * @param Amount $amount
     * @param string $acceptUrl
     */
    public function __construct(string $orderId, Amount $amount, string $acceptUrl)
    {
        $this->orderId = $orderId;
        $this->amount = $amount;
        $this->acceptUrl = $acceptUrl;
    }

    /**
     * @return string
     */
    public function getActionUrl()
    {
        return 'https://payment.architrade.com/paymentweb/start.action';
    }

    /**
     * @return Transaction
     */
    public function enableInstantCapture(): Transaction
    {
        $this->captureNow = true;

        return $this;
    }

    /**
     * @param string $language
     * @return Transaction
     */
    public function setLanguage(string $language): Transaction
    {
        $this->language = $language;

        return $this;
    }

    /**
     * @return array
     */
    public function toBodyParams(): array
    {
        $data = [
            'accepturl' => $this->acceptUrl,
            'currency' => $this->amount->getCurrency(),
            'amount' => $this->amount->getValue(),
            'orderid' => $this->orderId,
            'acquirerlang' => $this->language,
        ];

        if ($this->captureNow) {
            $data['capturenow'] = 'yes';
        }

        return $data;
    }
}
