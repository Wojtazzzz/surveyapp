<?php

declare (strict_types = 1);

namespace App\Http\Resources;

use App\Enums\QuestionType;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'surveyId' => $this->survey_id,
            'position' => $this->position,
            'title' => $this->type === QuestionType::SINGLE_CHOICE ? 'Wybierz jedną opcję:' : 'Wybierz dowolną ilość opcji:',
            'type' => $this->type,
            'created' => $this->created_at->toDateString(),
            'updated' => $this->updated_at->toDateString(),
        ];
    }
}
