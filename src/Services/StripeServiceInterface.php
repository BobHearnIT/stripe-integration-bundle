<?php

namespace BobHearnIT\StripeIntegrationBundle\Services;

use BobHearnIT\StripeIntegrationBundle\Contracts\SubscriptionPlanInterface;

interface StripeServiceInterface
{
    public function createSubscription(SubscriptionPlanInterface $subscriptionPlan): SubscriptionPlanInterface;
}