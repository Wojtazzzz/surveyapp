<?php

declare (strict_types = 1);

namespace App\Http\Controllers;

use App\Http\Requests\Survey\StoreRequest;
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

    public function store(StoreRequest $request): View
    {
        Survey::create($request->validated());

        return view('pages.surveys.create');
    }

    public function destroy(Survey $survey): RedirectResponse
    {
        $survey->delete();

        return to_route('surveys.index');
    }
}
