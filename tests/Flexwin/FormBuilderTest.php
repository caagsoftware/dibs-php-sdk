<?php

use IanRodrigues\DIBSPayment\Amount;
use IanRodrigues\DIBSPayment\DIBS;
use IanRodrigues\DIBSPayment\Flexwin\FormBuilder;
use IanRodrigues\DIBSPayment\Flexwin\Transaction;
use PHPUnit\Framework\TestCase;

class FormBuilderTest extends TestCase
{
    public function testRenderForm()
    {
        $dibs = new DIBS('merchant-id', 'merchant-secret');
        $transaction = new Transaction('order-12345', new Amount('usd', 10000), 'http://www.google.com/');

        $builder = new FormBuilder($dibs, $transaction, 'Pay with DIBS');

        $expected = "<form method=\"post\" action=\"https://payment.architrade.com/paymentweb/start.action\" accept-charset=\"utf-8\">";
        $expected .= "<input type=\"hidden\" name=\"merchant\" value=\"merchant-id\">";
        $expected .= "<input type=\"hidden\" name=\"accepturl\" value=\"http://www.google.com/\">";
        $expected .= "<input type=\"hidden\" name=\"currency\" value=\"USD\">";
        $expected .= "<input type=\"hidden\" name=\"amount\" value=\"10000\">";
        $expected .= "<input type=\"hidden\" name=\"orderid\" value=\"order-12345\">";
        $expected .= "<button type=\"submit\">Pay with DIBS</button>";
        $expected .= "</form>";

        $this->assertEquals($expected, $builder->render());
    }
}
