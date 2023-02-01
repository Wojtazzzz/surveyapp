<?php

declare (strict_types = 1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\QuestionResource;
use App\Models\Survey;
use Illuminate\Http\Resources\Json\JsonResource;

class SurveyQuestionController extends Controller
{
    public function index(Survey $survey): JsonResource
    {
        return QuestionResource::collection($survey->questions);
    }
}
