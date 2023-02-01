<?php

declare (strict_types = 1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OptionResource extends JsonResource
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
            'questionId' => $this->question_id,
            'value' => $this->id,
            'title' => $this->title,
            'created' => $this->created_at->toDateString(),
            'updated' => $this->updated_at->toDateString(),
        ];
    }
}
