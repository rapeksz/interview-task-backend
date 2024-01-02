<?php

declare(strict_types=1);

namespace App\Modules\Approval\Application;

use App\Domain\Enums\StatusEnum;
use App\Modules\Approval\Api\ApprovalFacadeInterface;
use App\Modules\Approval\Api\Dto\ApprovalDto;
use App\Modules\Approval\Api\Events\EntityApproved;
use App\Modules\Approval\Api\Events\EntityRejected;
use App\Modules\Approval\Api\Exceptions\StatusAlreadyAssignedException;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\Eloquent\Model;
use LogicException;

final readonly class ApprovalFacade implements ApprovalFacadeInterface
{
    public function __construct(
        private Dispatcher $dispatcher
    ) {
    }

    /**
     * @throws StatusAlreadyAssignedException
     */
    public function apply(ApprovalDto $dto): Model
    {
        $status = StatusEnum::tryFrom($dto->status->value);

        if (StatusEnum::APPROVED === $status) {
            return $this->approve($dto);
        }

        if (StatusEnum::REJECTED === $status) {
            return $this->reject($dto);
        }

        throw new LogicException('Incorrect approval status.');
    }

    /**
     * @throws LogicException
     * @throws StatusAlreadyAssignedException
     */
    public function approve(ApprovalDto $dto): Model
    {
        $model = $this->getModel($dto);
        $this->validate($model);
        $this->dispatcher->dispatch(new EntityApproved($dto));
        $model->status = $dto->status->value;

        return $model;
    }

    /**
     * @throws LogicException
     * @throws StatusAlreadyAssignedException
     */
    public function reject(ApprovalDto $dto): Model
    {
        $model = $this->getModel($dto);
        $this->validate($model);
        $this->dispatcher->dispatch(new EntityRejected($dto));
        $model->status = $dto->status->value;

        return $model;
    }

    /**
     * @throws StatusAlreadyAssignedException
     */
    private function validate(Model $model): void
    {
        $modelStatus = StatusEnum::tryFrom($model->status);

        if (StatusEnum::DRAFT !== $modelStatus) {
            throw new StatusAlreadyAssignedException('approval status is already assigned');
        }
    }

    private function getModel(ApprovalDto $dto): Model
    {
        $repository = RepositoryFactory::create($dto->entity);

        return $repository->findById($dto->id->toString());
    }
}
