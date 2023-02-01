<?php

declare (strict_types = 1);

namespace App\Http\Requests\Question;

use App\Rules\UpdateQuestionValidPosition;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'position' => [
                'required',
                'numeric',
                new UpdateQuestionValidPosition($this->survey),
            ],
            'content' => [
                'required',
                'string',
                'min:5',
            ],
            'type' => [
                'required',
                'in:Single choice,Multiple choice',
            ],

        ];
    }
}
