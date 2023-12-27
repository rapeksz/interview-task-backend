<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Http\Resources;

use App\Modules\Companies\Infrastructure\Http\Resources\BilledCompanyResource;
use App\Modules\Companies\Infrastructure\Http\Resources\CompanyResource;
use App\Modules\Products\Infrastructure\Http\Resources\ProductResource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class InvoiceResource extends JsonResource
{
    /**
     * @param  Request  $request
     */
    public function toArray($request): array|Arrayable|JsonSerializable
    {
        return [
            'invoice_number' => $this->number,
            'invoice_date' => $this->date,
            'due_date' => $this->due_date,
            'company' => new CompanyResource($this->company),
            'billed_company' => new BilledCompanyResource($this->billedCompany),
            'products' => ProductResource::collection($this->products),
            'total_price' => '',
        ];
    }
}
