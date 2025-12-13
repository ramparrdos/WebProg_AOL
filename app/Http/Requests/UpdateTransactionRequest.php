<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTransactionRequest extends FormRequest
{
   
   public function rules(): array
    {
    return [
        'category_id' => ['required','exists:categories,id'],
        'amount'      => ['required','numeric'],
        'type'        => ['required','in:income,expense'],
        'description' => ['nullable','string','max:1000'],
        'date'        => ['required','date'],
    ];
    }

}
