<?php

declare (strict_types = 1);

namespace App\Http\Controllers;

use App\Http\Requests\Option\StoreRequest;
use App\Http\Requests\Option\UpdateRequest;
use App\Models\Option;
use App\Models\Question;
use App\Models\Survey;
use Illuminate\Http\RedirectResponse;
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

    public function edit(Survey $survey, Question $question, Option $option)
    {
        return view('pages.options.edit', [
            'survey' => $survey,
            'question' => $question,
            'option' => $option,
        ]);
    }

    public function update(UpdateRequest $request, Survey $survey, Question $question, Option $option)
    {
        $option->update($request->validated());

        return to_route('questions.options.index', [
            'survey' => $survey,
            'question' => $question,
        ]);
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
