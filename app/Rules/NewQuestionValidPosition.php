<?php

declare (strict_types = 1);

namespace App\Rules;

use App\Models\Survey;
use Illuminate\Contracts\Validation\Rule;

class NewQuestionValidPosition implements Rule
{
    private Survey $survey;

    public function __construct(Survey $survey)
    {
        $this->survey = $survey;
    }

    public function passes($attribute, $value)
    {
        foreach ($this->survey->questions as $question) {
            if ($question->position === (int) $value) {
                return true;
            }
        }

        $availablePosition = $this->survey->questions()->max('position') + 1;

        if ($availablePosition === (int) $value) {
            return true;
        }

        return false;
    }

    public function message()
    {
        return 'Field :attribute was filled incorrect';
    }
}
