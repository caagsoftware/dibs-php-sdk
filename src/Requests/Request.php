<?php

namespace IanRodrigues\DIBSPayment\Requests;

abstract class Request
{
    /**
     * @return string
     */
    abstract public function getHttpMethod(): string;

    /**
     * @return string
     */
    abstract public function getEndpoint(): string;
}
