<?php

namespace App\Http\Requests\Admin;

use App\Rules\AlphaName;
use Illuminate\Foundation\Http\FormRequest;

class UsersRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255', new AlphaName],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['nullable', 'confirmed'],
            'roles.*' => ['exists:roles,id'],
            'media_id' => ['nullable', 'exists:media,id'],
        ];

        if ($this->method() !== 'POST'
            && $this->route()->user
        ) {
            $rules['email'] = ['required', 'email', "unique:users,email,{$this->route()->user->id},id"];
        }

        return $rules;
    }
}
