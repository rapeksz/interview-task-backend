<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Api;

use Illuminate\Database\Eloquent\Collection;

interface InvoiceFacadeInterface
{
    public function getAll(): Collection;
}
