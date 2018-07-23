<?php

namespace CaagSoftware\DIBSPayment\Requests\PaymentHandling;

class Cancel extends Refund
{
    /**
     * @return string
     */
    public function getEndpoint(): string
    {
        return '/cgi-adm/cancel.cgi';
    }

    /**
     * @return array
     */
    public function toBodyParams(): array
    {
        return [
            'transact' => $this->transact,
            'orderid' => $this->orderId,
            'textreply' => 'yes',
        ];
    }
}
