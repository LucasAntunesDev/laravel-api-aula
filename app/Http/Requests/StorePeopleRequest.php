<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePeopleRequest extends FormRequest {
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'name' => 'required|max:255',
            'email' => 'required|email',
            'address' => 'required',
            'state' => 'required|min:2|max:2',
        ];
    }
}
