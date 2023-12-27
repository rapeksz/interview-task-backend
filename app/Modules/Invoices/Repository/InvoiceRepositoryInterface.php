<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Repository;

use App\Modules\Approval\Api\Dto\ApprovalDto;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface InvoiceRepositoryInterface
{
    public function findById(string $id): Model;

    public function getAll(): Collection;

    public function updateStatus(ApprovalDto $dto): void;
}
