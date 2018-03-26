<?php

use CaagSoftware\DIBSPayment\DIBS;
use CaagSoftware\DIBSPayment\Requests\Handler;
use PHPUnit\Framework\TestCase;

class HandlerTest extends TestCase
{
    public function testHandleDIBSRequest()
    {
        $dibs = new DIBS('merchant-id', 'merchant-secret');
        $request = new FakeRequest();

        $handler = new Handler($dibs, new class {
            public function request($method, $uri, $body)
            {
                return $this;
            }

            public function getBody()
            {
                return $this;
            }

            public function getContents()
            {
                return "result=0";
            }
        });

        $this->assertArrayHasKey('status_code', $handler->handle($request));
    }
}
