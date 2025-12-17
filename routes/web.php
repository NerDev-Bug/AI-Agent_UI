<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FastAPIController;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ReportPDFController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\User_AccountController;

Route::get('/', function (){
    return Inertia::render('Login');
});
    
Route::get('/ai_agent/survey', function () {
    return Inertia::render('AI-Agent-UI/AI-AgentForm');
});

Route::get('/register', function () {
    return Inertia::render('Register');
});
Route::post('/user_register', [User_AccountController::class, 'store']);
Route::post('/login', [User_AccountController::class, 'login']);

Route::post('/api/analyze-file', [FastAPIController::class, 'analyzeFile']);
Route::post('/api/confirm-analysis', [FastAPIController::class, 'confirmAnalysis']);
Route::get('/api/ai-agent/progress/{jobId}', [FastAPIController::class, 'getProgress']);

Route::post('/export-report-pdf', [ReportPDFController::class, 'exportPDF']);

