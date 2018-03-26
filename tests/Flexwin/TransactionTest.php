<?php

use IanRodrigues\DIBSPayment\Amount;
use IanRodrigues\DIBSPayment\Flexwin\Transaction;
use PHPUnit\Framework\TestCase;

class TransactionTest extends TestCase
{
    public function testGetters()
    {
        $transaction = new Transaction('order-12345', new Amount('usd', 10000), 'http://www.google.com/');

        $this->assertEquals('https://payment.architrade.com/paymentweb/start.action', $transaction->getActionUrl());
    }

    /** @test */
    public function testEnableInstantCapture()
    {
        $transaction = new Transaction('order-12345', new Amount('usd', 10000), 'http://www.google.com/');

        $this->assertEquals([
            'accepturl' => 'http://www.google.com/',
            'currency' => 'USD',
            'amount' => 10000,
            'orderid' => 'order-12345',
        ], $transaction->toBodyParams());

        $transaction->enableInstantCapture();
        $this->assertEquals([
            'accepturl' => 'http://www.google.com/',
            'currency' => 'USD',
            'amount' => 10000,
            'orderid' => 'order-12345',
            'capturenow' => 'yes',
        ], $transaction->toBodyParams());
    }
}
