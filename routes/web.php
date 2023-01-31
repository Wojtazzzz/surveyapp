<?php

use App\Http\Controllers\SurveyController;
use Illuminate\Support\Facades\Route;

Route::get("/index", [SurveyController::class, 'index'])->name('surveys.index');
Route::delete("/survey/{survey}", [SurveyController::class, 'destroy'])->name('surveys.destroy');
Route::get("/survey/create", [SurveyController::class, 'create'])->name('surveys.create');
Route::post("/survey", [SurveyController::class, 'store'])->name('surveys.store');
