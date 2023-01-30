<?php

declare (strict_types = 1);

namespace Tests\Browser;

use App\Enums\SurveyStatus;
use App\Models\Survey;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\SurveysIndexPage;
use Tests\DuskTestCase;

// @TODO: tests: go to questions page, go to edit page, go to create surve page
class IndexPageTest extends DuskTestCase
{
    public function test_no_surveys(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new SurveysIndexPage())
                ->assertSeeNoSurveysMessage()
                ->assertSurveysTableDoesntExist();
        });
    }

    public function test_see_surveys_in_table(): void
    {
        $createdAt = now()->subMinutes(4);

        Survey::factory()->create([
            'name' => 'Test Survey',
            'status' => SurveyStatus::READY,
            'created_at' => $createdAt,
        ]);

        Survey::factory()->create([
            'name' => 'Another test Survey',
            'status' => SurveyStatus::TESTING,
            'created_at' => $createdAt,
        ]);

        $this->browse(function (Browser $browser) use ($createdAt) {
            $browser->visit(new SurveysIndexPage())
                ->assertDontSeeNoSurveysMessage()
                ->assertSurveysTableExist()
                ->assertSurvey('Test Survey', SurveyStatus::READY, $createdAt)
                ->assertSurvey('Another test Survey', SurveyStatus::TESTING, $createdAt);
        });
    }

    public function test_delete_survey(): void
    {
        $createdAt = now()->subMinutes(8);

        Survey::factory()->create([
            'name' => 'Test Survey',
            'status' => SurveyStatus::READY,
            'created_at' => $createdAt,
        ]);

        $this->browse(function (Browser $browser) use ($createdAt) {
            $browser->visit(new SurveysIndexPage())
                ->assertDontSeeNoSurveysMessage('There are no Surveys in the App. You can create new one by click on button above')
                ->assertSurveysTableExist()
                ->assertSurvey('Test Survey', SurveyStatus::READY, $createdAt)
                ->deleteSurvey()
                ->assertSurveysTableDoesntExist()
                ->assertSeeNoSurveysMessage('There are no Surveys in the App. You can create new one by click on button above');
        });
    }
}
