<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
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
                'max:255',
            ],
            'email' => [
                'required',
                'email',
                'unique:admins,email',
            ],
            'password' => [
                'required',
                'string',
//                Password::min(8)
//                    ->mixedCase()
//                    ->numbers()
//                    ->symbols()
//                    ->uncompromised(),
                'confirmed',
            ],

        ];
    }
}
