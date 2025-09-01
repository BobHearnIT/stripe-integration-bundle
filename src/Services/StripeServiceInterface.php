<?php

namespace BobHearnIT\StripeIntegrationBundle\Services;

use BobHearnIT\StripeIntegrationBundle\Contracts\SubscriptionPlanInterface;
use BobHearnIT\StripeIntegrationBundle\Model\StripeResult;

interface StripeServiceInterface
{
    public function createSubscription(SubscriptionPlanInterface $subscriptionPlan): StripeResult;
}