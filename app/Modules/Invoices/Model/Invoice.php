<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Model;

use App\Modules\Companies\Model\Company;
use App\Modules\Products\Model\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Invoice extends Model
{
    use HasFactory;

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
}
