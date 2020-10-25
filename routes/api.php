<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\HealthController;
use App\Http\Controllers\PractiseController;
use App\Http\Controllers\QuestionController;
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

Route::group([
    'prefix' => 'health',
], function () {
    Route::get('status', [HealthController::class, 'status']);
});

Route::prefix('auth')
    ->group(function ($router) {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');
        Route::post('me', [AuthController::class, 'me'])->middleware('auth:api');
        // Route::post('refresh', [AuthController::class, 'refresh']);
    });

Route::middleware(['auth:api'])
    ->prefix('practise')
    ->group(function ($router) {
        Route::get('record', [PractiseController::class, 'recordInfo']);
        Route::post('record', [PractiseController::class, 'recordSave']);
        Route::post('summary', [PractiseController::class, 'recordSummary']);

        Route::get('current-subject', [PractiseController::class, 'currentSubject']);

    });

Route::middleware(['auth:api'])
    ->prefix('category')
    ->group(function ($router) {
        Route::post('index', [CategoryController::class, 'index']);
        Route::post('buy', [CategoryController::class, 'buy']);

        // Route::post('tree', [CategoryController::class, 'tree']);
    });

Route::middleware(['auth:api'])
    ->prefix('chapter')
    ->group(function ($router) {
        Route::post('index', [ChapterController::class, 'index']);
        // Route::post('tree', [ChapterController::class, 'tree']);
    });

Route::middleware(['auth:api'])
    ->prefix('question')
    ->group(function ($router) {
        Route::post('index', [QuestionController::class, 'index']);
        Route::post('detail', [QuestionController::class, 'detail']);

        Route::get('note', [QuestionController::class, 'noteInfo']);
        Route::post('note', [QuestionController::class, 'noteSave']);
    });
