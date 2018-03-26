<?php

namespace IanRodrigues\DIBSPayment\Flexwin;

class FormBuilder
{
    /**
     * @var Transaction
     */
    private $transaction;

    /**
     * @var string
     */
    private $submitText;

    /**
     * Create new FormBuilder instance.
     *
     * @param Transaction $transaction
     * @param string $submitText
     */
    public function __construct(Transaction $transaction, string $submitText = 'Go to DIBS')
    {
        $this->tranasaction = $transaction;
        $this->submitText = $submitText;
    }

    /**
     * @return string
     */
    private function openForm(): string
    {
        return "<form method=\"post\" action=\"{$this->transaction->getActionUrl()}\" accept-charset=\"utf-8\">";
    }

    /**
     * @return string
     */
    private function closeForm(): string
    {
        return "</form>";
    }

    /**
     * @param string $name
     * @param string $value
     *
     * @return string
     */
    private function hiddenField(string $name, string $value): string
    {
        return "<input type=\"hidden\" name=\"{$name}\" value=\"{$value}\">";
    }

    /**
     * @return string
     */
    private function submitButton(): string
    {
        return "<button type=\"submit\">{$this->submitText}</button>";
    }

    /**
     * @return string
     */
    public function render(): string
    {
        $form = $this->openForm();

        foreach ($this->tranasaction->getBodyParams() as $name => $value) {
            $form .= $this->hiddenField($name, $value);
        }

        $form .= $this->submitButton();
        $form .= $this->closeForm();

        return $form;
    }
}
