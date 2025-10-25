<?php

use App\Http\Controllers\Api\TranscriptionController;
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

Route::middleware('auth:sanctum')->group(function () {
    // Transcription routes
    Route::apiResource('transcriptions', TranscriptionController::class);
    
    // Additional custom routes can be added here
    // Example: Route::post('transcriptions/{transcription}/publish', [TranscriptionController::class, 'publish']);
});
