<?php

namespace BobHearnIT\StripeIntegrationBundle\Client;

interface StripeClientInterface
{
    public function getClient(): StripeClientInterface;
}