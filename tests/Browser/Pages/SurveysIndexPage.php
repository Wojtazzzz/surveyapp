<?php

declare (strict_types = 1);

namespace Tests\Browser\Pages;

use App\Enums\SurveyStatus;
use Carbon\Carbon;
use Laravel\Dusk\Browser;
use Laravel\Dusk\Page;

class SurveysIndexPage extends Page
{
    public function url(): string
    {
        return '/index';
    }

    public function assert(Browser $browser): void
    {
        $browser->assertPathIs($this->url())
            ->assertTitle('SurveyApp - List of Surveys')
            ->assertSeeIn('h2', 'List of Surveys')
            ->assertSeeIn('a', 'New Survey');
    }

    public function assertSurveysTableDoesntExist(Browser $browser): void
    {
        $browser->assertMissing('table');
    }

    public function assertSurveysTableExist(Browser $browser): void
    {
        $browser->assertSeeIn('thead', 'NAME')
            ->assertSeeIn('thead', 'STATUS')
            ->assertSeeIn('thead', 'CREATED AT')
            ->assertSeeIn('thead', 'QUESTIONS')
            ->assertSeeIn('thead', 'ACTIONS');
    }

    public function assertSurvey(Browser $browser, string $name, SurveyStatus $status, Carbon $createdAt): void
    {
        $browser->assertSeeIn('tbody', $name)
            ->assertSeeIn('tbody', strtoupper($status->value))
            ->assertSeeIn('tbody', $createdAt);
    }

    public function assertSeeNoSurveysMessage(Browser $browser): void
    {
        $browser->assertSee('There are no Surveys in the App. You can create new one by click on button above');
    }

    public function assertDontSeeNoSurveysMessage(Browser $browser): void
    {
        $browser->assertDontSee('There are no Surveys in the App. You can create new one by click on button above');
    }

    public function deleteSurvey(Browser $browser): void
    {
        $browser->click('form button[type="submit"]')
            ->acceptDialog();
    }
}
