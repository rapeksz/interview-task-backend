<?php

declare(strict_types=1);

namespace App\Modules\Approval\Application;

use App\Domain\Enums\EntityEnum;
use App\Modules\Invoices\Model\Invoice;
use LogicException;

final readonly class EntityFactory
{
    public static function create(string $entity): string
    {
        return match ($entity) {
            EntityEnum::INVOICE->value => Invoice::class,
            default => throw new LogicException('Unexpected entity type.')
        };
    }
}
