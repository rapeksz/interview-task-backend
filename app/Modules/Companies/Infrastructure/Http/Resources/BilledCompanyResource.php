<?php

declare(strict_types=1);

namespace App\Modules\Companies\Infrastructure\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class BilledCompanyResource extends JsonResource
{
    /**
     * @param  Request  $request
     */
    public function toArray($request): array|Arrayable|JsonSerializable
    {
        return [
            'name' => $this->name,
            'street_address' => $this->street,
            'city' => $this->city,
            'zip_code' => $this->zip,
            'phone' => $this->phone,
            'email_address' => $this->email,
        ];
    }
}
