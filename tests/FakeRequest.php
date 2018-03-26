<?php

use CaagSoftware\DIBSPayment\Contracts\HasBodyParams;
use CaagSoftware\DIBSPayment\Requests\Request;

class FakeRequest extends Request implements HasBodyParams
{
    /**
     * @return string
     */
    public function getHttpMethod(): string
    {
        return 'POST';
    }

    /**
     * @return string
     */
    public function getEndpoint(): string
    {
        return '/fake';
    }

    /**
     * @return array
     */
    public function toBodyParams(): array
    {
        return [
            'fake' => true,
        ];
    }
}
