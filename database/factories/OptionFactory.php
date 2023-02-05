<?php

declare (strict_types = 1);

namespace Database\Factories;

use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Option>
 */
class OptionFactory extends Factory
{
    public function definition()
    {
        return [
            'question_id' => $this->faker->numberBetween(1, Question::max('id')),
            'title' => $this->faker->words(3, true),
        ];
    }
}
