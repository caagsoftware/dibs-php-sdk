<?php

namespace CaagSoftware\DIBSPayment\Flexwin;

class Result
{
    /**
     * @var int
     */
    private $statuscode;

    /**
     * @var int
     */
    private $approvalcode;

    /**
     * @var int
     */
    private $transact;

    /**
     * @var string[]
     */
    private $messages = [
        '0' => 'The transaction has been sent to the acquirer, but no response was received.',
        '1' => 'The transaction is declined by acquirer.',
        '2' => 'The transaction is approved by acquirer.',
        '3' => 'The transaction capture request is sent to the acquirer and DIBS awaits response.',
        '4' => 'The transaction capture is declined by the acquirer.',
        '5' => 'The transaction capture is approved by the acquirer.',
        '6' => 'The transaction authorization is deleted at the acquirer. If the transaction is still alive a reauthorization can be made.',
        '7' => 'The transaction is balanced.',
        '8' => 'The transaction is balanced and partially refunded.',
        '9' => 'The refund request is sent to the acquirer.',
        '10' => 'The refund is declined by the acquirer.',
        '11' => 'The refund is approved by the acquirer.',
        '12' => 'The transaction capture is pending.',
        '13' => 'The transaction is a "ticket" transaction.',
        '14' => 'The "ticket" transaction is deleted.',
        '15' => 'The transaction refund is pending.',
        '16' => 'The transaction is waiting for the shop to approve the transaction.',
        '17' => 'The transaction is declined by DIBS.',
        '18' => 'The transaction is a multicapture transaction and is still active.',
        '19' => 'The transaction is a multicapture transaction and is not active.',
        '26' => 'The transaction outcome is not yet decided by the acquirer, DIBS will continue to poll the transaction status.',
    ];

    /**
     * Create new Flexwin Result instance.
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        foreach ($data as $property => $value) {
            $this->setProperty($property, $value);
        }
    }

    /**
     * @param string $property
     * @param string $value
     */
    private function setProperty(string $property, string $value): void
    {
        if (property_exists($this, $property)) {
            $this->{$property} = $value;
        }
    }

    /**
     * Whether the transaction was approved.
     *
     * @return bool
     */
    public function isApproved(): bool
    {
        return in_array($this->statuscode, [5, 12]);
    }

    /**
     * @return int
     */
    public function getApprovalCode(): int
    {
        return (int) $this->approvalcode;
    }

    /**
     * @return int
     */
    public function getTransactId(): int
    {
        return (int) $this->transact;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->messages[$this->statuscode];
    }
}
