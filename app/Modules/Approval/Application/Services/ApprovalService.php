<?php

declare(strict_types=1);

namespace App\Modules\Approval\Application\Services;

use App\Domain\Enums\StatusEnum;
use App\Modules\Approval\Api\ApprovalFacadeInterface;
use App\Modules\Approval\Api\Dto\ApprovalDto;
use App\Modules\Approval\Api\Exceptions\StatusAlreadyAssignedException;
use App\Modules\Approval\Application\RepositoryFactory;
use Illuminate\Database\Eloquent\Model;
use LogicException;

final readonly class ApprovalService
{
    public function __construct(private ApprovalFacadeInterface $approvalFacade)
    {
    }

    /**
     * @throws StatusAlreadyAssignedException
     */
    public function apply(ApprovalDto $dto): Model
    {
        $status = StatusEnum::tryFrom($dto->status->value);
        $repository = RepositoryFactory::create($dto->entity);
        $model = $repository->findById($dto->id->toString());
        $modelStatus = StatusEnum::tryFrom($model->status);

        if (StatusEnum::DRAFT !== $modelStatus) {
            throw new StatusAlreadyAssignedException('Invoice status already assigned.');
        }

        if (StatusEnum::DRAFT === $status) {
            throw new LogicException('Approval status cannot be a draft.');
        }

        if (StatusEnum::APPROVED === $status) {
            $this->approvalFacade->approve($dto);
        }

        if (StatusEnum::REJECTED === $status) {
            $this->approvalFacade->reject($dto);
        }

        return $repository->findById($dto->id->toString());
    }
}
