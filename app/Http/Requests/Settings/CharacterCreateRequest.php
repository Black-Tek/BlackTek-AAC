<?php

namespace App\Http\Requests\Settings;

use App\Rules\ValidPlayerData;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CharacterCreateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                new ValidPlayerData,
                Rule::unique('players', 'name'),
            ],
            'sex' => [
                'required',
                'integer',
                new ValidPlayerData,
            ],
            'vocation' => [
                'required',
                'integer',
                new ValidPlayerData,
            ],
            'town_id' => [
                'required',
                'integer',
                new ValidPlayerData,
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Please enter a character name.',
            'name.unique' => 'This character name is already taken.',
            'sex.required' => 'Please select a sex for your character.',
            'sex.integer' => 'Invalid sex selection.',
            'vocation.required' => 'Please select a vocation for your character.',
            'vocation.integer' => 'Invalid vocation selection.',
            'town_id.required' => 'Please select a town for your character.',
            'town_id.integer' => 'Invalid town selection.',
        ];
    }

    /**
     * Get custom attribute names for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => 'character name',
            'sex' => 'sex',
            'vocation' => 'vocation',
            'town_id' => 'town',
        ];
    }
}
