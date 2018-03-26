<?php

namespace IanRodrigues\DIBSPayment\Requests;

abstract class Request
{
    /**
     * @return string
     */
    protected function getHttpMethod(): string {}

    /**
     * @return string
     */
    protected function getEndpoint(): string {}
}
