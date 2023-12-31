<?php

declare(strict_types=1);

use App\Modules\Approval\Api\Http\Controllers\ApprovalController;
use App\Modules\Invoices\Api\Http\Controllers\ShowInvoicesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('invoices', ShowInvoicesController::class);
Route::put('invoices/{id}/approval', ApprovalController::class);
