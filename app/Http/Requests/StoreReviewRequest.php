<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
{
    public function rules()
   {
      return [
          'content' => 'required|string',
        ];
   }
   public function authorize()
   {
       return true;
    }
}
