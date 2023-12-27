<?php

declare(strict_types=1);

namespace App\Modules\Approval\Application;

use App\Domain\Enums\StatusEnum;
use App\Modules\Approval\Api\ApprovalFacadeInterface;
use App\Modules\Approval\Api\Dto\ApprovalDto;
use App\Modules\Approval\Api\Events\EntityApproved;
use App\Modules\Approval\Api\Events\EntityRejected;
use Illuminate\Contracts\Events\Dispatcher;
use LogicException;

final readonly class ApprovalFacade implements ApprovalFacadeInterface
{
    public function __construct(
        private Dispatcher $dispatcher
    ) {
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

    /**
     * @throws LogicException
     */
    private function validate(ApprovalDto $dto): void
    {
        if (StatusEnum::DRAFT !== StatusEnum::tryFrom($dto->status->value)) {
            throw new LogicException('approval status is already assigned');
        }
    }
}
