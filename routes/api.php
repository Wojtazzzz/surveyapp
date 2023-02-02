<?php

use App\Http\Controllers\Api\V1\QuestionOptionController;
use App\Http\Controllers\Api\V1\SurveyController;
use App\Http\Controllers\Api\V1\SurveyQuestionController;
use App\Http\Middleware\WithoutEditingSurveys;
use App\Http\Middleware\WithoutTestingSurveys;
use Illuminate\Support\Facades\Route;

Route::name('api.v1.')
    ->prefix('/v1')
    ->middleware([WithoutEditingSurveys::class, WithoutTestingSurveys::class])
    ->group(function () {
        Route::get('/survey/{survey}', [SurveyController::class, 'show'])->name('surveys.show');
        Route::get('/survey-questions/{survey}', [SurveyQuestionController::class, 'index'])->name('surveys.questions.index');
        Route::get('/survey-questions-options/{survey}/{question}', [QuestionOptionController::class, 'index'])->name('questions.options.index');
    });
