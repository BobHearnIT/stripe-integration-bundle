<?php

namespace BobHearnIT\StripeIntegrationBundle\Model;

use BobHearnIT\StripeIntegrationBundle\Contracts\SubscriptionPlanInterface;
use Symfony\Component\Intl\Currencies;

class SubscriptionPlanModel implements SubscriptionPlanInterface
{
    public const array INTERVALS = [
        'day', 'month', 'week', 'year'
    ];

    public ?string $name = null {
        get {
            return $this->name;
        }
    }

    public ?int $amount = null {
        get {
            return $this->amount;
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

    public array $features = [] {
        get {
            return $this->features;
        }
    }

    private function __construct()
    {
        /** This model can't be initialized out of "build" scope. */
    }

    /** {@inheritDoc} */
    public static function build(
        string $name,
        int $amount,
        string $currency,
        string $interval,
        array $features = [],
    ): self
    {
        $model = new self();

        $model->name = $name;
        $model->amount = $amount;

        $currency = strtoupper($currency);

        \Locale::setDefault('en');
        if (!in_array($currency, array_keys(Currencies::getNames()))) {
            throw new \InvalidArgumentException('The currency "' . $currency . '" is not a valid one.');
        }

        $model->currency = $currency;

        if (!in_array($interval, self::INTERVALS)) {
            throw new \InvalidArgumentException('The interval "' . $interval . '" is not a valid one.');
        }

        $model->interval = $interval;
        $model->features = $features;

        return $model;
    }
}