<?php

namespace BobHearnIT\StripeIntegrationBundle\Model;

use BobHearnIT\StripeIntegrationBundle\Contracts\PaymentInterface;

class PaymentModel implements PaymentInterface
{
    private int $amount;
    private string $currency;
    private int $userId;
    private int $subscriptionType;

    public static function build(): self
    {
        $model = new self();

        return $model;
    }
}