<?php

namespace App\Http\Requests\TodoRequests;

use Illuminate\Foundation\Http\FormRequest;

class CompleteTodoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'id' => ['required', 'exists:App\Models\Todo,id']
        ];
    }
}
