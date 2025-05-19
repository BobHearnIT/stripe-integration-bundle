<?php

namespace BobHearnIT\StripeIntegrationBundle\Contracts;

use BobHearnIT\StripeIntegrationBundle\Model\SubscriptionPlanModel;

interface SubscriptionPlanInterface
{
    /** Create a subscription plan model. */
    public static function build(string $name, int $amount, string $currency, string $interval): SubscriptionPlanModel;
}