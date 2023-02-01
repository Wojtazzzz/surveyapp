<?php

use App\Http\Controllers\Api\V1\QuestionOptionController;
use App\Http\Controllers\Api\V1\SurveyController;
use App\Http\Controllers\Api\V1\SurveyQuestionController;
use Illuminate\Support\Facades\Route;

Route::name('api.v1.')
    ->prefix('/v1')
    ->group(function () {
        Route::get('/survey/{survey}', [SurveyController::class, 'show'])->name('survey.show');
        Route::get('/survey-questions/{survey}', [SurveyQuestionController::class, 'index'])->name('survey.questions.index');
        Route::get('/survey-questions-options/{survey}/{question}', [QuestionOptionController::class, 'index'])->name('questions.options.index');
    });
