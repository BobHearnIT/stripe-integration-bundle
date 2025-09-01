<?php

namespace BobHearnIT\StripeIntegrationBundle\Model;

use BobHearnIT\StripeIntegrationBundle\Contracts\SubscriptionPlanInterface;
use Symfony\Component\Intl\Currencies;

class SubscriptionPlanModel implements SubscriptionPlanInterface
{
    public ?string $name = null {
        get {
            return $this->name;
        }
    }

    public ?string $currency = null {
        get {
            return $this->currency;
        }
    }

    public ?string $interval = null {
        get {
            return $this->interval;
        }
    }

    /** @var RecurrenceModel[] */
    public array $recurrences = [] {
        get {
            return $this->recurrences;
        }
    }

    public ?object $object = null {
        get {
            return $this->object;
        }
    }

    public ?string $stripeProductId = null;
    public ?string $stripePriceId = null;

    private function __construct()
    {
        /** This model can't be initialized out of "build" scope. */
    }

    /** {@inheritDoc} */
    public static function build(
        ?string $stripeProductId,
        string $name,
        string $currency,
        array $recurrences,
        $refObject = null,
    ): self
    {
        $model = new self();

        $model->stripeProductId = $stripeProductId;
        $model->name = $name;

        $currency = strtoupper($currency);

        \Locale::setDefault('en');
        if (!in_array($currency, array_keys(Currencies::getNames()))) {
            throw new \InvalidArgumentException('The currency "' . $currency . '" is not a valid one.');
        }

        $model->currency = $currency;
        $model->recurrences = $recurrences;
        $model->object = $refObject;

        return $model;
    }

    public function setStripeProductId(string $stripeProductId): self
    {
        $this->stripeProductId = $stripeProductId;

        return $this;
    }

    public function getStripeProductId(): ?string
    {
        return $this->stripeProductId;
    }
}