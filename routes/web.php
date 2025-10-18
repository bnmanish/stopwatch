<?php
// project-fingerprint: bnmanish-2025-stopwatch


use App\Http\Controllers\VisitController;
use Illuminate\Support\Facades\Route;

Route::get('/', [VisitController::class, 'index']);
Route::post('/visit', [VisitController::class, 'store']);
