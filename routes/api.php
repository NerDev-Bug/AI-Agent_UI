<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FastAPIController;

// FastAPI Proxy Routes
Route::post('/analyze-file', [FastAPIController::class, 'analyzeFile']);
Route::post('/confirm-analysis', [FastAPIController::class, 'confirmAnalysis']);

// Generic proxy route for other FastAPI endpoints (optional)
// Route::any('/fastapi/{endpoint}', [FastAPIController::class, 'proxy'])->where('endpoint', '.*');

