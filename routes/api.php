<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CongregationsController;
use App\Http\Controllers\Api\PublishersController;
use App\Http\Controllers\Api\StandPublishersController;
use App\Http\Controllers\Api\StandTemplateController;
use App\Http\Controllers\BuilderAssistant\WarehouseController;
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

Route::group(['middleware' => 'api'], function () {
    Route::prefix('auth')->group(static function () {
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/refresh', [AuthController::class, 'refresh']);
        Route::get('/user-profile', [AuthController::class, 'userProfile']);
    });

    Route::apiResource('publishers', PublishersController::class);
    Route::apiResource('congregations', CongregationsController::class);

    Route::post('stand/publishers', [StandPublishersController::class, 'store']);
    Route::put('stand/publishers', [StandPublishersController::class, 'update']);
    Route::delete('stand/publishers', [StandPublishersController::class, 'destroy']);

    Route::get('stand/templates', [StandTemplateController::class, 'index']);
    Route::get('week_days', [StandTemplateController::class, 'weekDays']);
});

Route::get('warehouse/list', [WarehouseController::class, 'index']);
Route::post('warehouse', [WarehouseController::class, 'store']);
