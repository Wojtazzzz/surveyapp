<?php

declare (strict_types = 1);

namespace App\Http\Requests\Survey;

use App\Rules\AlphaSpaces;
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
            'name' => [
                'required',
                'string',
                'min:5',
                'max:30',
                new AlphaSpaces(),
            ],
        ];
    }
}
