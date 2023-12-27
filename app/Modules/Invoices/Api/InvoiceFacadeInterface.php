<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Api;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\UuidInterface;

interface InvoiceFacadeInterface
{
    public function getById(UuidInterface $uuid): Model;

    public function getAll(): Collection;
}
