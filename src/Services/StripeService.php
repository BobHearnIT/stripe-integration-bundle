<?php

namespace BobHearnIT\StripeIntegrationBundle\Services;

use BobHearnIT\StripeIntegrationBundle\Client\StripeClientInterface;
use BobHearnIT\StripeIntegrationBundle\Contracts\SubscriptionPlanInterface;
use BobHearnIT\StripeIntegrationBundle\Model\StripeResult;
use BobHearnIT\StripeIntegrationBundle\Model\SubscriptionPlanModel;
use Stripe\Collection;
use Stripe\Price;
use Stripe\Product;
use Symfony\Contracts\Translation\TranslatorInterface;

readonly class StripeService implements StripeServiceInterface
{
    public function __construct(private StripeClientInterface $client, private TranslatorInterface $translator)
    {
    }

    public function createSubscription(SubscriptionPlanInterface $subscriptionPlan): StripeResult
    {
        /*if (!empty($subscriptionPlan->features)) {
            $this->createFeatures($subscriptionPlan);
        }*/

        $result = new StripeResult();

        $this->createProduct($result, $subscriptionPlan);
        $this->createProductPrice($result, $subscriptionPlan);

        $result->setSuccess(true);

        return $result;
    }

    protected function createProduct(StripeResult $result, SubscriptionPlanInterface $subscriptionPlan): StripeResult
    {
        $product = null;
        $products = $this->getClient()->products->all();
        foreach ($products->data as $pr) {
            if ($pr->name === $subscriptionPlan->name) {
                $product = $pr;
                $result->addMessage($this->translator->trans(
                    'The Stripe product "{product_name}" already exists.',
                    ['{product_name}' => $subscriptionPlan->name]
                ));
            }
        }

        if (null === $product) {
            $product = $this->getClient()->products->create(['name' => $subscriptionPlan->name]);
        }

        if ($subscriptionPlan->object && method_exists($subscriptionPlan->object, 'setStripeProductId')) {
            $subscriptionPlan->object->setStripeProductId($product->id);
        }

        $subscriptionPlan->setStripeProductId($product->id);

        return $result;
    }

    protected function createProductPrice(
        StripeResult $result,
        SubscriptionPlanInterface $subscriptionPlan
    ): StripeResult {
        $existedPrices = $this->getClient()->prices->all();

        foreach ($subscriptionPlan->recurrences as $recurrence) {
            $price = null;

            /** @var Price $existedPrice */
            foreach ($existedPrices->data as $existedPrice) {
                if ($recurrence->interval === $existedPrice->recurring->interval
                    && $recurrence->intervalCount === $existedPrice->recurring->interval_count
                ) {
                    $price = $existedPrice;
                    $result->addMessage($this->translator->trans(
                        'The Stripe price "{recurrence}" already exists on product "{product_name}".',
                        [
                            '{recurrence}' => sprintf('%s %s', $recurrence->intervalCount, $recurrence->interval),
                            '{product_name}' => $subscriptionPlan->name
                        ]
                    ));
                    break;
                }
            }

            if (null === $price) {
                $price = $this->getClient()->prices->create([
                    'product' => $subscriptionPlan->getStripeProductId(),
                    'unit_amount' => $recurrence->amount,
                    'currency' => $subscriptionPlan->currency,
                    'recurring' => [
                        'interval' => $recurrence->interval,
                        'interval_count' => $recurrence->intervalCount,
                    ],
                ]);
            }

            if ($recurrence->object && method_exists($recurrence->object, 'setStripePriceId')) {
                $recurrence->object->setStripePriceId($price->id);
            }

            $recurrence->setStripePriceId($price->id);
        }

        return $result;
    }

    protected function createFeatures(SubscriptionPlanInterface $subscriptionPlan): void
    {

    }

    private function getClient(): StripeClientInterface
    {
        return $this->client->getClient();
    }
}