<?php

namespace BobHearnIT\StripeIntegrationBundle\Model;

class RecurrenceModel
{
    public const array INTERVALS = [
        'day', 'month', 'week', 'year'
    ];

    public ?int $amount = null {
        get {
            return $this->amount;
        }
    }

    public string $interval {
        get {
            return $this->interval;
        }
    }

    public int $intervalCount = 1 {
        get {
            return $this->intervalCount;
        }
    }

    public ?object $object = null {
        get {
            return $this->object;
        }
    }

    protected ?string $stripePriceId = null;

    /** {@inheritDoc} */
    public static function build(
        string $interval,
        int $intervalCount,
        int $amount,
        $refObject = null,
    ): self
    {
        $model = new self();

        if (!in_array($interval, self::INTERVALS)) {
            throw new \InvalidArgumentException('The interval "' . $interval . '" is not a valid one.');
        }

        $model->interval = $interval;
        $model->intervalCount = $intervalCount;
        $model->amount = $amount;
        $model->object = $refObject;

        return $model;
    }

    public function setStripePriceId(string $stripePriceId): self
    {
        $this->stripePriceId = $stripePriceId;

        return $this;
    }

    public function getStripePriceId(): ?string
    {
        return $this->stripePriceId;
    }
}