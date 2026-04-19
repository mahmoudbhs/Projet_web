<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'content' => 'required|string|min:3',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
