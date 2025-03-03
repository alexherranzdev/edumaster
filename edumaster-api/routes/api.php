<?php

use App\Http\Controllers\StatsController;
use Edumaster\Learning\User\Infrastructure\Http\AuthController;
use Edumaster\Learning\User\Infrastructure\Http\DeleteUserController;
use Edumaster\Learning\User\Infrastructure\Http\ListUserController;
use Edumaster\Learning\User\Infrastructure\Http\UpdateUserController;
use Edumaster\Learning\Worksheet\Infrastructure\Http\WorksheetController;
use Edumaster\Learning\Worksheet\Infrastructure\Http\WorksheetResponseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::middleware('auth:sanctum')->group(function () {
  Route::get('/stats/totals', [StatsController::class, 'getTotals']);

  Route::get('/users', [ListUserController::class, 'listByRole']);
  Route::delete('/users/{id}', [DeleteUserController::class, 'execute']);
  Route::put('/users/{id}', [UpdateUserController::class, 'execute']);

  Route::get('/worksheets', [WorksheetController::class, 'index']);
  Route::post('/worksheets', [WorksheetController::class, 'store']);
  Route::post('/worksheets/{id}/submit', [WorksheetResponseController::class, 'store']);
  Route::put('/worksheets/{id}', [WorksheetController::class, 'update']);
  Route::get('/worksheets/{id}', [WorksheetController::class, 'show']);
  Route::delete('/worksheets/{id}', [WorksheetController::class, 'destroy']);
});

Route::get('/user', function (Request $request) {
  return new JsonResponse($request->user());
})->middleware('auth:sanctum');
