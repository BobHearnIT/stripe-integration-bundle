<?php

namespace BobHearnIT\StripeIntegrationBundle\Contracts;

interface RecurrenceInterface
{
    public static function build(
        string $interval,
        int $intervalCount,
        int $amount,
        $refObject = null,
    ): self;

    public function setStripePriceId(string $stripePriceId): self;

    /**
     * Return the Stripe price ID which they generate.
     */
    public function getStripePriceId(): ?string;
}