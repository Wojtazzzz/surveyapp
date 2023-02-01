<?php

declare (strict_types = 1);

namespace App\Http\Controllers;

use App\Http\Requests\Survey\StoreRequest;
use App\Http\Requests\Survey\UpdateRequest;
use App\Models\Survey;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SurveyController extends Controller
{
    public function index(): View
    {
        $surveys = Survey::get([
            'id',
            'name',
            'status',
            'created_at',
        ]);

        return view('pages.surveys.index', [
            'surveys' => $surveys,
        ]);
    }

    public function create(): View
    {
        return view('pages.surveys.create');
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $survey = Survey::create($request->validated());

        return to_route('surveys.questions.index', [
            'survey' => $survey,
        ]);
    }

    public function edit(Survey $survey): View
    {
        return view('pages.surveys.edit', [
            'survey' => $survey,
        ]);
    }

    public function update(UpdateRequest $request, Survey $survey): RedirectResponse
    {
        $survey->update($request->validated());

        return to_route('surveys.index');
    }

    public function destroy(Survey $survey): RedirectResponse
    {
        $survey->delete();

        return to_route('surveys.index');
    }
}
