<?php

declare (strict_types = 1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\SurveyResource;
use App\Models\Survey;
use Illuminate\Http\Resources\Json\JsonResource;

class SurveyController extends Controller
{
    public function show(Survey $survey): JsonResource
    {
        return SurveyResource::make($survey);
    }
}
