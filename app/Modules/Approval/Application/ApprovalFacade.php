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
    public function apply(ApprovalDto $dto): true
    {
        $status = StatusEnum::tryFrom($dto->status->value);

        if (StatusEnum::APPROVED === $status) {
            return $this->approve($dto);
        }

        if (StatusEnum::REJECTED === $status) {
            return $this->reject($dto);
        }

        throw new StatusAlreadyAssignedException('Incorrect approval status.');
    }

    /**
     * @throws LogicException
     */
    public function approve(ApprovalDto $dto): true
    {
        $this->validate($dto);
        $this->dispatcher->dispatch(new EntityApproved($dto));

        return true;
    }

    /**
     * @throws LogicException
     */
    public function reject(ApprovalDto $dto): true
    {
        $this->validate($dto);
        $this->dispatcher->dispatch(new EntityRejected($dto));

        return true;
    }

    private function validate(ApprovalDto $dto): void
    {
        $repository = RepositoryFactory::create($dto->entity);
        $invoice = $repository->findById($dto->id->toString());
        $modelStatus = StatusEnum::tryFrom($invoice->status);

        if (StatusEnum::DRAFT !== $modelStatus) {
            throw new LogicException('approval status is already assigned');
        }
    }
}
