<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AIController;

Route::post('/analyze-file', [AIController::class, 'analyze']);
Route::post('/confirm-analysis', [AIController::class, 'confirm']);

