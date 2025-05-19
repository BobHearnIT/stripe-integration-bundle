<?php

namespace BobHearnIT\StripeIntegrationBundle\Services;

use BobHearnIT\StripeIntegrationBundle\Client\StripeClientInterface;
use BobHearnIT\StripeIntegrationBundle\Model\SubscriptionPlanModel;

class StripeService implements StripeServiceInterface
{
    public function __construct(private readonly StripeClientInterface $client)
    {
    }

    public function createSubscription(SubscriptionPlanModel $subscriptionPlan): SubscriptionPlanModel
    {
        if (!empty($subscriptionPlan->features)) {
            $this->createFeatures($subscriptionPlan);
        }

        $this->createProduct($subscriptionPlan);
    }

    protected function createProduct(SubscriptionPlanModel $subscriptionPlan): void
    {
        $p = $this->getClient()->products->all();
        dd($p);

        $products = $this->getClient()->products->create(['name' => $subscriptionPlan->getName()]);
        dd($products);
    }

    protected function createFeatures(SubscriptionPlanModel $subscriptionPlan): void
    {

    }

    private function getClient(): StripeClientInterface
    {
        return $this->client->getClient();
    }

    /*public function createPayment()
    {
        try {
            $paymentIntent = PaymentIntent::create([
                'amount' => $amount * 100, // Montant en centimes
                'currency' => 'eur',
                'automatic_payment_methods' => ['enabled' => true],
                'metadata' => [
                    'user_id' => $this->getUser()->getId(),
                    'subscription_type' => $data['subscription_type'],
                ],
            ]);
        } catch (\Exception $e) {
            dd($e)
        }
    }*/
}