<?php

declare (strict_types = 1);

namespace Tests\Feature\Api;

use App\Enums\SurveyStatus;
use App\Models\Survey;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class SurveyTest extends TestCase
{
    public function test_return_not_found_when_model_not_exists(): void
    {
        $response = $this->getJson('/survey/1');

        $response->assertNotFound();
    }

    public function test_return_success_when_model_exists(): void
    {
        $survey = Survey::factory()->createOne([
            'status' => SurveyStatus::READY
        ]);

        $response = $this->getJson(route('api.v1.surveys.show', ['survey' => $survey]));

        $response->assertSuccessful();
    }

    public function test_return_correct_data(): void
    {
        $survey = Survey::factory()->createOne([
            'status' => SurveyStatus::READY
        ]);

        $response = $this->getJson(route('api.v1.surveys.show', ['survey' => $survey]));

        $response->assertJson(fn (AssertableJson $json) =>
            $json->where('id', $survey->id)
                ->where('name', $survey->name)
                ->where('status', SurveyStatus::READY->value)
                ->where('created', $survey->created_at->toDateString())
                ->where('updated', $survey->updated_at->toDateString())
        );
    }

    public function test_return_not_found_when_survey_has_editing_status(): void
    {
        $survey = Survey::factory()->createOne([
            'status' => SurveyStatus::EDITING
        ]);

        $response = $this->getJson(route('api.v1.surveys.show', ['survey' => $survey]));

        $response->assertNotFound();
    }

    public function test_return_not_found_when_survey_has_testing_status(): void
    {
        $survey = Survey::factory()->createOne([
            'status' => SurveyStatus::TESTING
        ]);

        $response = $this->getJson(route('api.v1.surveys.show', ['survey' => $survey]));

        $response->assertNotFound();
    }
}
