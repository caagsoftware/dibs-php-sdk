<?php

namespace IanRodrigues\DIBSPayment\Flexwin;

use IanRodrigues\DIBSPayment\Amount;
use IanRodrigues\DIBSPayment\DIBS;

class Transaction
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
     * Create new Transaction instance.
     *
     * @param DIBS $dibs
     * @param string $orderId
     * @param Amount $amount
     * @param string $acceptUrl
     */
    public function __construct(DIBS $dibs, string $orderId, Amount $amount, string $acceptUrl)
    {
        $this->dibs = $dibs;
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
     * @return void
     */
    public function mustCaptureNow(): void
    {
        $this->captureNow = true;
    }

    /**
     * @return array
     */
    public function getBodyParams(): array
    {
        $data = [
            'accepturl' => $this->acceptUrl,
            'currency' => $this->amount->getCurrency(),
            'amount' => $this->amount->getValue(),
            'orderid' => $this->orderId,
        ];

        if ($this->captureNow) {
            $data['capturenow'] = 'yes';
        }

        return $this->dibs->getBodyParams($data);
    }
}
