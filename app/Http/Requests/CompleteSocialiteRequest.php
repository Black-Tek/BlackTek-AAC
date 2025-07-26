<?php

namespace App\Http\Requests;

use App\Rules\ValidPassword;
use Illuminate\Foundation\Http\FormRequest;

class CompleteSocialiteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'account_name' => ['required', 'alpha_num', 'max:12', 'min:6', 'unique:accounts,name'],
            'password' => ['required', 'string', 'confirmed', new ValidPassword],
        ];
    }

    public function getUserData(string $email): array
    {
        return [
            'name' => $this->account_name,
            'email' => $email,
            'password' => $this->password,
        ];
    }
}
