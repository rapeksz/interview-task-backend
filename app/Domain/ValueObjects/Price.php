<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects;

readonly class Price
{
    public function __construct(public float $value, public Currency $currency)
    {
        if ($this->value < 0) {
            throw new \LogicException('The price value cannot be negative.');
        }
    }
}
