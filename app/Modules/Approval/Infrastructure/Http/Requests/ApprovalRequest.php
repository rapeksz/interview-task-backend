<?php

declare(strict_types=1);

namespace App\Modules\Approval\Infrastructure\Http\Requests;

use App\Domain\Enums\EntityEnum;
use App\Domain\Enums\StatusEnum;
use App\Modules\Approval\Api\Dto\ApprovalDto;
use App\Modules\Approval\Application\EntityFactory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Ramsey\Uuid\Uuid;

class ApprovalRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => ['required', 'uuid'],
            'status' => ['required', new Enum(StatusEnum::class)],
            'entity' => ['required', new Enum(EntityEnum::class)],
        ];
    }

    public function dto(): ApprovalDto
    {
        return new ApprovalDto(
            Uuid::fromString($this->route('id')),
            StatusEnum::tryFrom($this->json('status')),
            EntityFactory::create($this->json('entity'))
        );
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'id' => $this->route('id'),
            'status' => $this->json('status'),
            'entity' => $this->json('entity'),
        ]);
    }
}
