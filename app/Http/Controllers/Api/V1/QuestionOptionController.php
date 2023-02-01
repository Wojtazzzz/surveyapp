<?php

declare (strict_types = 1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\OptionResource;
use App\Models\Question;
use App\Models\Survey;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionOptionController extends Controller
{
    public function index(Survey $survey, Question $question): JsonResource
    {
        return OptionResource::collection($question->options);
    }
}
