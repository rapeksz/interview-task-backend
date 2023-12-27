<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects;

use App\Domain\Enums\CurrencyEnum;
use LogicException;

readonly class Currency
{
    public function __construct(public string $isoCode)
    {
        if (CurrencyEnum::USD !== CurrencyEnum::tryFrom($this->isoCode)) {
            throw new LogicException('Currency code is not a USD.');
        }
    }
}
