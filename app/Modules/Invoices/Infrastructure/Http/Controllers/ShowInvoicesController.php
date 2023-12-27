<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Http\Controllers;

use App\Infrastructure\Controller;
use App\Modules\Invoices\Api\InvoiceFacadeInterface;
use App\Modules\Invoices\Infrastructure\Http\Resources\InvoiceResource;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

final class ShowInvoicesController extends Controller
{
    public function __invoke(InvoiceFacadeInterface $invoiceFacade): JsonResponse
    {
        try {
            $invoices = $invoiceFacade->getAll();
            $data = InvoiceResource::collection($invoices);

            return response()->json($data, Response::HTTP_OK);
        } catch (Exception $e) {
            Log::error($e->getTraceAsString());

            return response()->json(['error' => 'Something went wrong.'], Response::HTTP_NOT_FOUND);
        }
    }
}
