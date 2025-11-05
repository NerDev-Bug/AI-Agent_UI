<?php

use App\Http\Controllers\ProfileController;
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
// Route::get('/header', function () {
//     return Inertia::render('Layouts/Header');
// });


Route::post('/export-report-pdf', [ReportPDFController::class, 'exportPDF']);

