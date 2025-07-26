<?php

namespace App\Http\Requests;

use App\Rules\ValidPassword;
use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'alpha_num', 'max:12', 'min:6', 'unique:accounts'],
            'email' => ['required', 'email', 'unique:users,email', 'unique:accounts,email'],
            'password' => ['required', 'string', 'confirmed', new ValidPassword],
        ];
    }

    public function getUserData(): array
    {
        return $this->only(['name', 'email', 'password']);
    }
}
