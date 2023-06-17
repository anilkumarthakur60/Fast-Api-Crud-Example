<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function rules()
    {
        return [
            'email' => [
                'required',
                'email',
                'exists:admins,email',
            ],
            'password' => [
                'required',
            ],
        ];
    }


    protected function prepareForValidation():void
    {
        $this->whenMissing('name', function () {
            $this->merge([
                'name' => strtolower($this->input('email')),
            ]);
        });

    }
}
