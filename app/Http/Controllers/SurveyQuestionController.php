<?php

declare (strict_types = 1);

namespace App\Http\Controllers;

use App\Http\Requests\Question\StoreRequest;
use App\Http\Requests\Question\UpdateRequest;
use App\Models\Question;
use App\Models\Survey;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SurveyQuestionController extends Controller
{
    public function index(Survey $survey): View
    {
        $questions = $survey->questions()
            ->orderBy('position')
            ->get([
                'id',
                'position',
                'content',
                'type',
            ]);

        return view('pages.questions.index', [
            'survey' => $survey,
            'questions' => $questions,
        ]);
    }

    public function create(Survey $survey): View
    {
        return view('pages.questions.create', [
            'survey' => $survey,
            'questions' => $survey->questions,
        ]);
    }

    public function store(StoreRequest $request, Survey $survey): RedirectResponse
    {
        $availablePosition = $survey->questions->max('position') + 1;

        if ($request->validated('position') !== $availablePosition) {
            if ((bool) $survey->questions) {
                $survey->questions()
                    ->where('position', '>=', $request->validated('position'))
                    ->orderBy('position', 'desc')
                    ->increment('position');
            }
        }

        $question = new Question($request->validated());

        $survey->questions()->save($question);

        return to_route('questions.options.index', [
            'survey' => $survey,
            'question' => $question,
        ]);
    }

    public function edit(Survey $survey, Question $question): View
    {
        return view('pages.questions.edit', [
            'survey' => $survey,
            'question' => $question,
        ]);
    }

    public function update(UpdateRequest $request, Survey $survey, Question $question): RedirectResponse
    {
        $newPosition = $request->validated('position');
        $oldPosition = $question->position;

        if ($newPosition !== $oldPosition) {
            if($newPosition > $oldPosition) {
                $survey->questions()
                    ->where('position', '>', $oldPosition)
                    ->where('position', '<=', $newPosition)
                    ->orderBy('position', 'asc')
                    ->decrement('position');
            }

            if ($newPosition < $oldPosition) {
                $survey->questions()
                ->where('position', '<', $oldPosition)
                ->where('position', '>=', $newPosition)
                ->orderBy('position')
                ->increment('position');
            }
        }

        $question->update($request->validated());

        return to_route('surveys.questions.index', [
            'survey' => $survey,
            'questions' => $survey->questions(),
        ]);
    }

    public function destroy(Survey $survey, Question $question): RedirectResponse
    {
        $question->delete();

        if ((bool) $survey->questions) {
            $survey->questions()
                ->where('position', '>', $question->position)
                ->orderBy('position', 'asc')
                ->decrement('position');
        }

        return to_route('surveys.questions.index', [
            'survey' => $survey,
        ]);
    }
}
