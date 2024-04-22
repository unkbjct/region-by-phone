<?php

use App\Jobs\SetBitrixField;
use App\Webhooks\PhoneRegionGetter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/setfield', function (Request $request) {
    $errs = [];

    if (!$request->has("phone") || $request->input("phone") === "") $errs['phone'] = 'phone is required field';
    if (!$request->has("leadId") || $request->input("leadId") === "") $errs['leadId'] = 'leadId is required field';

    if (sizeof($errs) > 0) return response()->json(
        [
            'status' => 'error',
            'errors' => $errs,
        ],
        422
    );

    SetBitrixField::dispatch($request->leadId, $request->phone);

    return response()->json(
        [
            'status' => 'success',
        ],
        200
    );
});
