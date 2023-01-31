<?php

declare (strict_types = 1);

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Survey;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SurveyQuestionController extends Controller
{
    public function index(Survey $survey): View
    {
        return view('pages.surveys.questions.index', [
            'survey' => $survey,
            'questions' => $survey->questions,
        ]);
    }

    public function create(Survey $survey)
    {
        //
    }

    public function store(Request $request, Survey $survey)
    {
        //
    }

    public function show(Survey $survey, Question $question)
    {
        //
    }

    public function edit(Survey $survey, Question $question)
    {
        //
    }

    public function update(Request $request, Survey $survey, Question $question)
    {
        //
    }

    public function destroy(Survey $survey, Question $question): RedirectResponse
    {
        $question->delete();

        return to_route('surveys.questions.index', [
            'survey' => $survey,
        ]);
    }
}
