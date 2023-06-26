<?php

use App\Http\Controllers\API\LinkController;
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

/**
 * API Domains
 */
Route::domain('api.' . config('app.domain'))
    ->middleware(['auth:sanctum'])
    ->group(function () {
        // Route::get('links/{id}/statistics', [LinkController::class, 'statistics']);
        Route::apiResource('links', LinkController::class);
    });
