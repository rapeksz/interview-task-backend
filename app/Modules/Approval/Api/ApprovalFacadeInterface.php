<?php

declare(strict_types=1);

namespace App\Modules\Approval\Api;

use App\Modules\Approval\Api\Dto\ApprovalDto;
use Illuminate\Database\Eloquent\Model;

interface ApprovalFacadeInterface
{
    public function approve(ApprovalDto $entity): Model;

    public function reject(ApprovalDto $entity): Model;
}
