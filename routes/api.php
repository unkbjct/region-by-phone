<?php

use App\Jobs\SetBitrixField;
use App\Webhooks\PhoneRegionGetter;
use App\Webhooks\RegionGetter;
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

Route::post('/setregion', function (Request $request) {
    $errs = [];

    if (!$request->has("phone") || $request->input("phone") === "") $errs['phone'] = 'phone is required field';
    if (!$request->has("lead_id") || $request->input("lead_id") === "") $errs['lead_id'] = 'lead_id is required field';

    if (sizeof($errs) > 0) return response()->json(
        [
            'status' => 'error',
            'error_message' => 'validation_error',
            'errors' => $errs,
        ],
        422
    );

    return RegionGetter::handler($request->input("lead_id"), $request->input("phone"));
});
