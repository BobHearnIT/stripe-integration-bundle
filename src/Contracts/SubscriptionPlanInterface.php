<?php

namespace BobHearnIT\StripeIntegrationBundle\Contracts;

interface SubscriptionPlanInterface
{
    /** Create a subscription plan model. */
    public static function build(
        ?string $stripeProductId,
        string $name,
        string $currency,
        array $recurrences,
        $refObject = null,
    ): self;

    public function setStripeProductId(string $stripeProductId): self;

    /**
     * Return the Stripe product ID which they generate.
     */
    public function getStripeProductId(): ?string;
}