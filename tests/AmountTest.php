<?php

use CaagSoftware\DIBSPayment\Amount;
use PHPUnit\Framework\TestCase;

class AmountTest extends TestCase
{
    public function testGetters()
    {
        $amount = new Amount('usd', 10000);

        $this->assertEquals('USD', $amount->getCurrency());
        $this->assertEquals(10000, $amount->getValue());
    }
}
