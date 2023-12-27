<?php

declare(strict_types=1);

namespace App\Modules\Approval\Application\Listeners;

use App\Modules\Approval\Api\Events\EntityApproved;
use App\Modules\Approval\Api\Events\EntityRejected;
use App\Modules\Approval\Application\RepositoryFactory;

final readonly class ApprovalListener
{
    public function handle(EntityApproved|EntityRejected $event): void
    {
        $dto = $event->approvalDto;
        $repository = RepositoryFactory::create($dto->entity);
        $repository->updateStatus($event->approvalDto);
    }
}
