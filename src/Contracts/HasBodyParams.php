<?php

namespace IanRodrigues\DIBSPayment\Contracts;

interface HasBodyParams
{
    /**
     * @return array
     */
    public function toBodyParams(): array;
}
