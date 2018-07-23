<?php

namespace CaagSoftware\DIBSPayment\Flexwin;

use CaagSoftware\DIBSPayment\Amount;
use CaagSoftware\DIBSPayment\Contracts\HasBodyParams;
use CaagSoftware\DIBSPayment\DIBS;

class Transaction implements HasBodyParams
{
    /**
     * @var DIBS
     */
    private $dibs;

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
            'callbackurl' => $this->acceptUrl,
            'notifyurl' => $this->acceptUrl,
            'cancelurl' => $this->acceptUrl,
            'currency' => DIBS::$currency_mapping[$this->amount->getCurrency()],
            'amount' => $this->amount->getValue(),
            'orderid' => $this->orderId,
            'lang' => $this->language,
            'acquirerlang' => $this->language,
            'decorator' => 'responsive',
        ];

        if ($this->dibs->getMd5key1() && $this->dibs->getMd5key2()) {
            $data['md5key'] = $this->generateMD5Key();
        }

        if ($this->captureNow) {
            $data['capturenow'] = 'yes';
        }

        return $data;
    }

    protected function generateMD5Key()
    {
        $parameter_string = 'merchant=' . $this->dibs->getMerchantId();
        $parameter_string .= '&orderid=' . $this->orderId;
        $parameter_string .= '&currency=' . DIBS::$currency_mapping[$this->amount->getCurrency()];
        $parameter_string .= '&amount=' . $this->amount->getValue();

        return md5($this->dibs->getMd5key2() . md5($this->dibs->getMd5key1() . $parameter_string));
    }
}
