<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Repositories;

use App\Modules\Approval\Api\Dto\ApprovalDto;
use App\Modules\Invoices\Model\Invoice;
use App\Modules\Invoices\Repository\InvoiceRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final readonly class InvoiceRepository implements InvoiceRepositoryInterface
{
    /**
     * @throws ModelNotFoundException
     */
    public function findById(string $id): Model
    {
        return Invoice::findOrFail($id);
    }

    public function getAll(): Collection
    {
        return Invoice::all();
    }

    /**
     * @throws ModelNotFoundException
     */
    public function updateStatus(ApprovalDto $dto): void
    {
        $this->findById($dto->id->toString())->update([
            'status' => $dto->status->value,
        ]);
    }
}
