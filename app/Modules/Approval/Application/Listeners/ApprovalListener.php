<?php

declare(strict_types=1);

namespace App\Modules\Approval\Application\Listeners;

use App\Modules\Approval\Api\Events\EntityApproved;
use App\Modules\Approval\Api\Events\EntityRejected;
use App\Modules\Invoices\Repository\InvoiceRepositoryInterface;

final readonly class ApprovalListener
{
    public function __construct(private InvoiceRepositoryInterface $invoiceRepository)
    {
    }

    public function handle(EntityApproved|EntityRejected $event): void
    {
        $this->invoiceRepository->updateStatus($event->approvalDto);
    }
}
