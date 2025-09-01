<?php

namespace BobHearnIT\StripeIntegrationBundle\Model;

class StripeResult
{
    protected bool $success = false;
    protected array $messages = [];

    public function setSuccess(bool $success): self
    {
        $this->success = $success;

        return $this;
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }

    public function addMessage(string $message): self
    {
        $this->messages[] = $message;

        return $this;
    }

    public function getMessages(): array
    {
        return $this->messages;
    }
}