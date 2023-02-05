<?php

declare (strict_types = 1);

namespace Database\Factories;

use App\Enums\QuestionType;
use App\Models\Question;
use App\Models\Survey;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question>
 */
class QuestionFactory extends Factory
{
    public function definition()
    {
        $survey_id = $this->faker->numberBetween(1, Survey::max('id'));

        return [
            'survey_id' => $survey_id,
            'position' => Question::where('survey_id', $survey_id)->max('position') + 1,
            'content' => $this->faker->text(200),
            'type' => $this->faker->randomElement([
                QuestionType::SINGLE_CHOICE,
                QuestionType::MULTIPLE_CHOICE,
            ])
        ];
    }
}
