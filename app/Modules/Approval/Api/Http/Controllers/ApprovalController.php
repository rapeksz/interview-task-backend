<?php

declare(strict_types=1);

namespace App\Modules\Approval\Api\Http\Controllers;

use App\Infrastructure\Controller;
use App\Modules\Approval\Api\ApprovalFacadeInterface;
use App\Modules\Approval\Api\Exceptions\StatusAlreadyAssignedException;
use App\Modules\Approval\Api\Http\Requests\ApprovalRequest;
use App\Modules\Invoices\Api\Http\Resources\InvoiceResource;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use LogicException;
use Symfony\Component\HttpFoundation\Response;

final class ApprovalController extends Controller
{
    public function __invoke(ApprovalRequest $request, ApprovalFacadeInterface $approval): JsonResponse
    {
        try {
            $model = $approval->apply($request->dto());
            $data = new InvoiceResource($model);

            return response()->json($data, Response::HTTP_CREATED);
        } catch (LogicException | StatusAlreadyAssignedException $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            Log::error($e->getTraceAsString());

            return response()->json(['error' => 'Something went wrong.'], Response::HTTP_NOT_FOUND);
        }
    }
}
