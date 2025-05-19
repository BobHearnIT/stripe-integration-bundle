<?php

namespace BobHearnIT\StripeIntegrationBundle\Client;

class StripeClient extends \Stripe\StripeClient implements StripeClientInterface
{
    public function __construct(private readonly string $stripePrivateKey)
    {
        parent::__construct($this->stripePrivateKey);
    }

    public function getClient(): StripeClientInterface
    {
        return $this;
    }
}