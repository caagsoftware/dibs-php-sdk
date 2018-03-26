<?php

namespace CaagSoftware\DIBSPayment\Contracts;

interface HasBodyParams
{
    /**
     * @return array
     */
    public function toBodyParams(): array;
}
