<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Model;

use App\Domain\Enums\CurrencyEnum;
use App\Domain\ValueObjects\Currency;
use App\Domain\ValueObjects\Price;
use App\Modules\Companies\Model\Company;
use App\Modules\Products\Model\Product;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Invoice extends Model
{
    use HasFactory;
    use HasUuids;

    public $fillable = [
        'status',
    ];

    public function company(): HasOne
    {
        return $this->hasOne(Company::class, 'id', 'company_id');
    }

    public function billedCompany(): HasOne
    {
        return $this->hasOne(Company::class, 'id', 'billed_company_id');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'invoice_product_lines')->withPivot(['quantity']);
    }

    public function getTotalPrice(): Price
    {
        $price = $this->products->pluck('price')->sum();

        return new Price($price, new Currency(CurrencyEnum::USD->value));
    }
}
