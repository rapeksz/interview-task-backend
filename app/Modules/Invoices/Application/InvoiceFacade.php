<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application;

use App\Modules\Invoices\Api\InvoiceFacadeInterface;
use App\Modules\Invoices\Repository\InvoiceRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

final readonly class InvoiceFacade implements InvoiceFacadeInterface
{
    public function __construct(private readonly InvoiceRepositoryInterface $invoiceRepository)
    {
    }

    public function getAll(): Collection
    {
        return $this->invoiceRepository->getAll();
    }
}
