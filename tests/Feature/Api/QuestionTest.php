<?php

declare (strict_types = 1);

namespace Tests\Feature\Api;

use App\Enums\QuestionType;
use App\Enums\SurveyStatus;
use App\Models\Question;
use App\Models\Survey;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class QuestionTest extends TestCase
{
    public function test_return_not_found_when_survey_not_exists(): void
    {
        $response = $this->getJson('/survey-questions/1');

        $response->assertNotFound();
    }

    public function test_return_success_when_survey_exists(): void
    {
        $survey = Survey::factory()->createOne([
            'status' => SurveyStatus::READY
        ]);

        $response = $this->getJson(route('api.v1.surveys.questions.index', ['survey' => $survey]));

        $response->assertSuccessful();
    }

    public function test_return_correct_data(): void
    {
        $survey = Survey::factory()->createOne([
            'status' => SurveyStatus::READY
        ]);

        $questions = Question::factory(3)->create();

        $response = $this->getJson(route('api.v1.surveys.questions.index', ['survey' => $survey]));

        $response->assertJson(function (AssertableJson $json) use ($questions, $survey) {
            $json->has(3);

            foreach ($questions as $question) {
                $json->has($question->id - 1, fn ($json) =>
                    $json->where('id', $question->id)
                        ->where('surveyId', $survey->id)
                        ->where('position', $question->position)
                        ->where('title', $question->type === QuestionType::SINGLE_CHOICE ? 'Wybierz jedną opcję:' : 'Wybierz dowolną ilość opcji:')
                        ->where('type', $question->type->value)
                        ->where('created', $question->created_at->toDateString())
                        ->where('updated', $question->updated_at->toDateString())
                );
            }
        });
    }

    public function test_return_only_relationed_questions(): void
    {
        $survey = Survey::factory()->createOne([
            'status' => SurveyStatus::READY
        ]);

        Question::factory(2)->create();

        // another survey with questions
        Survey::factory(3)
            ->create()
            ->each(function (Survey $survey) {
                Question::factory()->createOne([
                    'survey_id' => $survey->id,
                ]);
            });

        $response = $this->getJson(route('api.v1.surveys.questions.index', ['survey' => $survey]));

        $response->assertJson(fn (AssertableJson $json) => $json->has(2));
    }

    public function test_return_not_found_when_survey_has_editing_status(): void
    {
        $survey = Survey::factory()->createOne([
            'status' => SurveyStatus::EDITING
        ]);

        $response = $this->getJson(route('api.v1.surveys.questions.index', ['survey' => $survey]));

        $response->assertNotFound();
    }

    public function test_return_not_found_when_survey_has_testing_status(): void
    {
        $survey = Survey::factory()->createOne([
            'status' => SurveyStatus::TESTING
        ]);

        $response = $this->getJson(route('api.v1.surveys.questions.index', ['survey' => $survey]));

        $response->assertNotFound();
    }
}
