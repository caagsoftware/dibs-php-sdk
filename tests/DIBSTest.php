<?php

use CaagSoftware\DIBSPayment\Amount;
use CaagSoftware\DIBSPayment\DIBS;
use CaagSoftware\DIBSPayment\Requests\PaymentHandling\Refund;
use PHPUnit\Framework\TestCase;

class DIBSTest extends TestCase
{
    public function testGetters()
    {
        $dibs = new DIBS('merchant-id', 'merchant-secret');

        $this->assertEquals('merchant-id', $dibs->getMerchantId());
        $this->assertEquals('merchant-secret', $dibs->getMerchantSecret());
    }

    public function testTestEnvironment()
    {
        $dibs = new DIBS('merchant-id', 'merchant-secret');

        $this->assertFalse($dibs->isTestEnvironment());

        $dibs->setTestEnvironment();
        $this->assertTrue($dibs->isTestEnvironment());
    }

    public function testGetBodyParams()
    {
        $dibs = new DIBS('merchant-id', 'merchant-secret');

        $this->assertEquals([
            'merchant' => 'merchant-id',
        ], $dibs->toBodyParams());

        $dibs->setTestEnvironment();
        $this->assertEquals([
            'merchant' => 'merchant-id',
            'test' => 1,
        ], $dibs->toBodyParams());
    }

    public function testHandleDIBSRequests()
    {
        $dibs = new DIBS('merchant-id', 'merchant-secret');
        $refund = new Refund('123456', 'order-1234', new Amount('usd', 2990));

        $result = $dibs->handle($refund, new class {
            public function handle($request)
            {
                return ['status_code' => 0];
            }
        });

        $this->assertEquals(0, $result['status_code']);
    }
}
