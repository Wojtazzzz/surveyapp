<?php

declare (strict_types = 1);

namespace App\Http\Controllers;

use App\Http\Requests\Option\StoreRequest;
use App\Models\Option;
use App\Models\Question;
use App\Models\Survey;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class QuestionOptionController extends Controller
{
    public function index(Survey $survey, Question $question): View
    {
        $options = $question->options()
            ->orderBy('id')
            ->get([
                'id',
                'title',
            ]);

        return view('pages.options.index', [
            'survey' => $survey,
            'question' => $question,
            'options' => $options,
        ]);
    }

    public function create(Survey $survey, Question $question): View
    {
        return view('pages.options.create', [
            'survey' => $survey,
            'question' => $question,
        ]);
    }

    public function store(StoreRequest $request, Survey $survey, Question $question): RedirectResponse
    {
        $option = new Option($request->validated());

        $question->options()->save($option);

        return to_route('questions.options.index', [
            'survey' => $survey,
            'question' => $question,
        ]);
    }

    public function show(Question $question, Option $option)
    {
        //
    }

    public function edit(Question $question, Option $option)
    {
        //
    }

    public function update(Request $request, Question $question, Option $option)
    {
        //
    }

    public function destroy(Survey $survey, Question $question, Option $option): RedirectResponse
    {
        $option->delete();

        return to_route('questions.options.index', [
            'survey' => $survey,
            'question' => $question,
        ]);
    }
}
