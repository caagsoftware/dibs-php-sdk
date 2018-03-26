<?php

use CaagSoftware\DIBSPayment\Amount;
use CaagSoftware\DIBSPayment\Requests\PaymentHandling\Refund;
use PHPUnit\Framework\TestCase;

class RefundTest extends TestCase
{
    public function testGetters()
    {
        $refund = new Refund(123456, 'order-1234', new Amount('usd', 10000));

        $this->assertEquals('POST', $refund->getHttpMethod());
        $this->assertEquals('/cgi-adm/refund.cgi', $refund->getEndpoint());
        $this->assertEquals([
            'transact' => 123456,
            'orderid' => 'order-1234',
            'currency' => 'USD',
            'amount' => 10000,
            'textreply' => 'success',
        ], $refund->toBodyParams());
    }
}
