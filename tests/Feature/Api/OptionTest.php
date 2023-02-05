<?php

declare (strict_types = 1);

namespace Tests\Feature\Api;

use App\Enums\SurveyStatus;
use App\Models\Option;
use App\Models\Question;
use App\Models\Survey;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class OptionTest extends TestCase
{
    public function test_return_not_found_when_survey_not_exists(): void
    {
        $response = $this->getJson('/survey-questions-options/1/1');

        $response->assertNotFound();
    }

    public function test_return_not_found_when_question_not_exists(): void
    {
        Survey::factory()->createOne();

        $response = $this->getJson('/survey-questions-options/1/1');

        $response->assertNotFound();
    }

    public function test_return_success_when_survey_and_question_exists(): void
    {
        $survey = Survey::factory()->createOne([
            'status' => SurveyStatus::READY,
        ]);

        $question = Question::factory()->createOne();

        $response = $this->getJson(route('api.v1.questions.options.index', [
            'survey' => $survey,
            'question' => $question,
        ]));

        $response->assertSuccessful();
    }

    public function test_return_not_found_when_survey_has_editing_status(): void
    {
        $survey = Survey::factory()->createOne([
            'status' => SurveyStatus::EDITING
        ]);

        $question = Question::factory()->createOne();

        $response = $this->getJson(route('api.v1.questions.options.index', [
            'survey' => $survey,
            'question' => $question,
        ]));

        $response->assertNotFound();
    }

    public function test_return_not_found_when_survey_has_testing_status(): void
    {
        $survey = Survey::factory()->createOne([
            'status' => SurveyStatus::TESTING
        ]);

        $question = Question::factory()->createOne();

        $response = $this->getJson(route('api.v1.questions.options.index', [
            'survey' => $survey,
            'question' => $question,
        ]));

        $response->assertNotFound();
    }

    public function test_return_correct_data(): void
    {
        $survey = Survey::factory()->createOne([
            'status' => SurveyStatus::READY
        ]);

        $question = Question::factory()->createOne();

        $options = Option::factory(3)->create();

        $response = $this->getJson(route('api.v1.questions.options.index', [
            'survey' => $survey,
            'question' => $question,
        ]));

        $response->assertJson(function (AssertableJson $json) use ($options, $question) {
            $json->has(3);

            foreach ($options as $option) {
                $json->has($option->id - 1, fn ($json) =>
                    $json->where('id', $option->id)
                        ->where('questionId', $question->id)
                        ->where('value', $option->id)
                        ->where('title', $option->title)
                        ->where('created', $option->created_at->toDateString())
                        ->where('updated', $option->updated_at->toDateString())
                );
            }
        });
    }

    public function test_return_only_related_options(): void
    {
        $survey = Survey::factory()->createOne([
            'status' => SurveyStatus::READY
        ]);

        $question = Question::factory()->createOne();

        $options = Option::factory(2)->create();

        // another question with options
        Question::factory(1)
            ->create()
            ->each(function (Question $question) {
                Option::factory(8)->create([
                    'question_id' => $question->id,
                ]);
            });

        $response = $this->getJson(route('api.v1.questions.options.index', [
            'survey' => $survey,
            'question' => $question,
        ]));

        $response->assertJson(function (AssertableJson $json) use ($options, $question) {
            $json->has(2);

            foreach ($options as $option) {
                $json->has($option->id - 1, fn ($json) =>
                    $json->where('id', $option->id)
                        ->where('questionId', $question->id)
                        ->where('value', $option->id)
                        ->where('title', $option->title)
                        ->where('created', $option->created_at->toDateString())
                        ->where('updated', $option->updated_at->toDateString())
                );
            }
        });
    }
}
