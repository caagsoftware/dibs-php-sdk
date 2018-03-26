<?php

namespace CaagSoftware\DIBSPayment;

class Amount
{
    /**
     * @var string
     */
    private $currency;

    /**
     * @var int
     */
    private $value;

    /**
     * Create new Amount instance.
     *
     * @param string $currency
     * @param int    $value
     */
    public function __construct(string $currency, int $value)
    {
        $this->currency = strtoupper($currency);
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }
}
