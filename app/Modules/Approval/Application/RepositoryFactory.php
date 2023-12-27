<?php

declare(strict_types=1);

namespace App\Modules\Approval\Application;

use App\Modules\Invoices\Model\Invoice;
use App\Modules\Invoices\Repository\InvoiceRepositoryInterface;
use LogicException;

final readonly class RepositoryFactory
{
    public static function create(string $model): InvoiceRepositoryInterface
    {
        return match ($model) {
            Invoice::class => app(InvoiceRepositoryInterface::class),
            default => throw new LogicException('Unrecognized model type.'),
        };
    }
}
