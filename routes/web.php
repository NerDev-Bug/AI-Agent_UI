<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FastAPIController;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ReportPDFController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function (){
    return Inertia::render('Login');
});
    
Route::get('/aiform', function () {
    return Inertia::render('AI-Agent-UI/AI-AgentForm');
});
Route::get('/index', function () {
    return Inertia::render('AI-Agent-UI/Index');
});


Route::post('/api/analyze-file', [FastAPIController::class, 'analyzeFile']);
Route::post('/api/confirm-analysis', [FastAPIController::class, 'confirmAnalysis']);
Route::get('/api/ai-agent/progress/{jobId}', [FastAPIController::class, 'getProgress']);

Route::post('/export-report-pdf', [ReportPDFController::class, 'exportPDF']);

