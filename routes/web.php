<?php

use App\Http\Controllers\SurveyController;
use App\Http\Controllers\SurveyQuestionController;
use Illuminate\Support\Facades\Route;

Route::get("/index", [SurveyController::class, 'index'])->name('surveys.index');
Route::delete("/survey/{survey}", [SurveyController::class, 'destroy'])->name('surveys.destroy');
Route::get("/survey/create", [SurveyController::class, 'create'])->name('surveys.create');
Route::post("/survey", [SurveyController::class, 'store'])->name('surveys.store');

Route::get("/survey/questions/{survey}", [SurveyQuestionController::class, 'index'])->name('surveys.questions.index');
Route::delete("/survey/question-delete/{survey}/{question}", [SurveyQuestionController::class, 'destroy'])->name('surveys.questions.destroy');
