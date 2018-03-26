<?php

use CaagSoftware\DIBSPayment\Flexwin\Result;
use PHPUnit\Framework\TestCase;

class ResultTest extends TestCase
{
    public function testGetters()
    {
        $result = new Result([
            'statuscode' => 5,
            'approvalcode' => '112233',
            'transact' => '123456',
        ]);

        $this->assertTrue($result->isApproved());
        $this->assertEquals(112233, $result->getApprovalCode());
        $this->assertEquals(123456, $result->getTransactId());
        $this->assertEquals('The transaction capture is approved by the acquirer.', $result->getMessage());
    }
}
