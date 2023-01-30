<?php

declare (strict_types = 1);

namespace Database\Factories;

use App\Enums\SurveyStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Survey>
 */
class SurveyFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => $this->faker->sentence(4),
            'status' => $this->faker->randomElement(SurveyStatus::cases()),
        ];
    }
}
