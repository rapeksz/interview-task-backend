<?php

declare(strict_types=1);

namespace App\Modules\Products\Model;

use App\Domain\ValueObjects\Currency;
use App\Domain\ValueObjects\Price;
use App\Modules\Invoices\Model\Invoice;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;
    use HasUuids;

    public function invoices(): BelongsToMany
    {
        return $this->belongsToMany(Invoice::class, 'invoice_product_lines')->withPivot(['quantity']);
    }

    public function getUnitPrice(): Price
    {
        return new Price($this->price / $this->pivot->quantity, new Currency($this->currency));
    }
}
