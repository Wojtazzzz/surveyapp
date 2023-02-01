<?php

use App\Http\Controllers\QuestionOptionController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\SurveyQuestionController;
use Illuminate\Support\Facades\Route;

Route::get('/index', [SurveyController::class, 'index'])->name('surveys.index');
Route::delete('/survey/{survey}', [SurveyController::class, 'destroy'])->name('surveys.destroy');
Route::get('/survey/edit/{survey}', [SurveyController::class, 'edit'])->name('surveys.edit');
Route::patch('/survey/{survey}', [SurveyController::class, 'update'])->name('surveys.update');
Route::get('/survey/create', [SurveyController::class, 'create'])->name('surveys.create');
Route::post('/survey', [SurveyController::class, 'store'])->name('surveys.store');

Route::get('/survey/questions/{survey}', [SurveyQuestionController::class, 'index'])->name('surveys.questions.index');
Route::get('/survey/question-create/{survey}', [SurveyQuestionController::class, 'create'])->name('surveys.questions.create');
Route::post('/survey/question-store/{survey}', [SurveyQuestionController::class, 'store'])->name('surveys.questions.store');
Route::get('/survey/question-edit/{survey}/{question}', [SurveyQuestionController::class, 'edit'])->name('surveys.questions.edit');
Route::patch('/survey/question-update/{survey}/{question}', [SurveyQuestionController::class, 'update'])->name('surveys.questions.update');
Route::delete('/survey/question-delete/{survey}/{question}', [SurveyQuestionController::class, 'destroy'])->name('surveys.questions.destroy');

Route::get('/survey/question-options/{survey}/{question}', [QuestionOptionController::class, 'index'])->name('questions.options.index');
Route::get('/survey/question-option-create/{survey}/{question}', [QuestionOptionController::class, 'create'])->name('questions.options.create');
Route::post('/survey/question-option-store/{survey}/{question}', [QuestionOptionController::class, 'store'])->name('questions.options.store');
Route::get('/survey/question-option-edit/{survey}/{question}/{option}', [QuestionOptionController::class, 'edit'])->name('questions.options.edit');
Route::patch('/survey/question-option-update/{survey}/{question}/{option}', [QuestionOptionController::class, 'update'])->name('questions.options.update');
Route::delete('/survey/question-option-delete/{survey}/{question}/{option}', [QuestionOptionController::class, 'destroy'])->name('questions.options.destroy');
