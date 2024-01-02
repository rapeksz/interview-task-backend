<?php

declare(strict_types=1);

namespace App\Modules\Companies\Model;

use App\Modules\Invoices\Model\Invoice;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Company extends Model
{
    use HasFactory;
    use HasUuids;

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }
}
