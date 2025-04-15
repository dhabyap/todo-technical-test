<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChecklistController;
use App\Http\Controllers\ChecklistItemController;

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

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware(['auth:api'])->group(function () {
    Route::get('/checklist', [ChecklistController::class, 'index']);
    Route::post('/checklist', [ChecklistController::class, 'store']);
    Route::delete('/checklist/{id}', [ChecklistController::class, 'destroy']);

    Route::get('/checklist/{id}/item', [ChecklistItemController::class, 'index']);
    Route::post('/checklist/{id}/item', [ChecklistItemController::class, 'store']);
    Route::get('/checklist/{checklistId}/item/{itemId}', [ChecklistItemController::class, 'show']);
    Route::put('/checklist/{checklistId}/item/{itemId}', [ChecklistItemController::class, 'toggle']);
    Route::put('/checklist/{checklistId}/item/rename/{itemId}', [ChecklistItemController::class, 'rename']);
    Route::delete('/checklist/{checklistId}/item/{itemId}', [ChecklistItemController::class, 'destroy']);
    
});

