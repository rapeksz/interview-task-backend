<?php

declare(strict_types=1);

namespace App\Modules\Products\Infrastructure\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class ProductResource extends JsonResource
{
    /**
     * @param  Request  $request
     */
    public function toArray($request): array|Arrayable|JsonSerializable
    {
        return [
            'name' => $this->name,
            'quantity' => $this->pivot->quantity,
            'unit_price' => $this->getUnitPrice()->value,
            'total' => $this->price,
        ];
    }
}
