<?php

use App\Http\Controllers\V1\AuthController as V1AuthController;
use App\Http\Controllers\V1\CategoryController as V1CategoryController;
use App\Http\Controllers\V1\ChapterController as V1ChapterController;
use App\Http\Controllers\V1\HealthController as V1HealthController;
use App\Http\Controllers\V1\AppMenuController as V1AppMenuController;
use App\Http\Controllers\V1\PackageController as V1PackageController;
use App\Http\Controllers\V1\PractiseController as V1PractiseController;
use App\Http\Controllers\V1\QuestionController as V1QuestionController;

use App\Http\Controllers\VD\AuthController;
use App\Http\Controllers\VD\CategoryController;
use App\Http\Controllers\VD\ChapterController;
use App\Http\Controllers\VD\HealthController;
use App\Http\Controllers\VD\PractiseController;
use App\Http\Controllers\VD\QuestionController;
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

// Version 1

Route::group([
    'prefix' => 'v1',
], function () {
    Route::group([
        'prefix' => 'health',
    ], function () {
        Route::get('status', [V1HealthController::class, 'status']);
    });

    Route::prefix('menu')
        ->middleware(['auth:api'])
        ->group(function ($router) {
            Route::get('index', [V1AppMenuController::class, 'index']);
        });

    Route::prefix('auth')
        ->group(function ($router) {
            Route::post('login', [V1AuthController::class, 'login'])
                ->name('login'); // Resolve: "Route [login] not defined" of auth:api tip
            Route::post('logout', [V1AuthController::class, 'logout'])
                ->middleware('auth:api');
            Route::get('me', [V1AuthController::class, 'me'])
                ->middleware('auth:api');
            // Route::post('refresh', [V1AuthController::class, 'refresh']);
        });

    Route::prefix('category')
        ->middleware(['auth:api'])
        ->group(function ($router) {
            Route::get('index', [V1CategoryController::class, 'index']);
            Route::get('search', [V1CategoryController::class, 'search']);
            Route::get('opened', [V1CategoryController::class, 'opened']);
            Route::post('open', [V1CategoryController::class, 'open']);

            // Route::post('tree', [V1CategoryController::class, 'tree']);
        });

    Route::prefix('chapter')
        ->middleware(['auth:api'])
        ->group(function ($router) {
            Route::get('index', [V1ChapterController::class, 'index']);

            // Route::post('tree', [V1ChapterController::class, 'tree']);
        });

    Route::prefix('package')
        ->middleware(['auth:api'])
        ->group(function ($router) {
            Route::get('index', [V1PackageController::class, 'list']);
        });

    Route::prefix('practise')
        ->middleware(['auth:api'])
        ->group(function ($router) {
            Route::get('record', [V1PractiseController::class, 'recordInfo']);
            Route::post('record', [V1PractiseController::class, 'recordSave']);

            Route::get('summary', [V1PractiseController::class, 'recordSummary']);
            Route::get('current-subject', [V1PractiseController::class, 'currentSubject']);
        });

    Route::prefix('question')
        ->middleware(['auth:api'])
        ->group(function ($router) {
            Route::get('index', [V1QuestionController::class, 'index']);
            Route::get('detail', [V1QuestionController::class, 'detail']);
            Route::get('note', [V1QuestionController::class, 'noteInfo']);
            Route::post('note', [V1QuestionController::class, 'noteSave']);
        });
});

// =========================================================================

Route::group([
    'prefix' => 'health',
], function () {
    Route::get('status', [HealthController::class, 'status']);
});

Route::prefix('auth')
    ->group(function ($router) {
        Route::post('login', [AuthController::class, 'login'])
            ->name('login'); // Resolve: "Route [login] not defined" of auth:api tip
        Route::post('logout', [AuthController::class, 'logout'])
            ->middleware('auth:api');
        Route::get('me', [AuthController::class, 'me'])
            ->middleware('auth:api');
        // Route::post('refresh', [AuthController::class, 'refresh']);
    });

Route::prefix('category')
    ->middleware(['auth:api'])
    ->group(function ($router) {
        Route::get('index', [CategoryController::class, 'index']);
        Route::get('search', [CategoryController::class, 'search']);
        Route::get('opened', [CategoryController::class, 'opened']);
        Route::post('open', [CategoryController::class, 'open']);

        // Route::post('tree', [CategoryController::class, 'tree']);
    });

Route::prefix('chapter')
    ->middleware(['auth:api'])
    ->group(function ($router) {
        Route::get('index', [ChapterController::class, 'index']);

        // Route::post('tree', [ChapterController::class, 'tree']);
    });

Route::prefix('practise')
    ->middleware(['auth:api'])
    ->group(function ($router) {
        Route::get('record', [PractiseController::class, 'recordInfo']);
        Route::post('record', [PractiseController::class, 'recordSave']);

        Route::get('summary', [PractiseController::class, 'recordSummary']);
        Route::get('current-subject', [PractiseController::class, 'currentSubject']);
    });

Route::prefix('question')
    ->middleware(['auth:api'])
    ->group(function ($router) {
        Route::get('index', [QuestionController::class, 'index']);
        Route::get('detail', [QuestionController::class, 'detail']);
        Route::get('note', [QuestionController::class, 'noteInfo']);
        Route::post('note', [QuestionController::class, 'noteSave']);
    });
