<?php

use App\Http\Controllers\QuestionOptionController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\SurveyQuestionController;
use App\Http\Middleware\WithoutEditingSurveys;
use Illuminate\Support\Facades\Route;

Route::controller(SurveyController::class)
    ->name('surveys.')
    ->group(function () {
        Route::get('/index', 'index')->name('index');
        Route::get('/survey/show/{survey}', 'show')->name('show')->middleware(WithoutEditingSurveys::class);
        Route::delete('/survey/delete/{survey}', 'destroy')->name('destroy');
        Route::get('/survey/edit/{survey}', 'edit')->name('edit');
        Route::patch('/survey/update/{survey}', 'update')->name('update');
        Route::get('/survey/create', 'create')->name('create');
        Route::post('/survey/store', 'store')->name('store');
    });

Route::controller(SurveyQuestionController::class)
    ->prefix('/survey')
    ->name('surveys.questions.')
    ->group(function () {
        Route::get('/questions/{survey}', 'index')->name('index');
        Route::get('/question-create/{survey}', 'create')->name('create');
        Route::post('/question-store/{survey}', 'store')->name('store');
        Route::get('/question-edit/{survey}/{question}', 'edit')->name('edit');
        Route::patch('/question-update/{survey}/{question}', 'update')->name('update');
        Route::delete('/question-delete/{survey}/{question}', 'destroy')->name('destroy');
    });

Route::controller(QuestionOptionController::class)
    ->prefix('/survey')
    ->name('questions.options.')
    ->group(function () {
        Route::get('/question-options/{survey}/{question}', 'index')->name('index');
        Route::get('/question-option-create/{survey}/{question}', 'create')->name('create');
        Route::post('/question-option-store/{survey}/{question}', 'store')->name('store');
        Route::get('/question-option-edit/{survey}/{question}/{option}', 'edit')->name('edit');
        Route::patch('/question-option-update/{survey}/{question}/{option}', 'update')->name('update');
        Route::delete('/question-option-delete/{survey}/{question}/{option}', 'destroy')->name('destroy');
    });
