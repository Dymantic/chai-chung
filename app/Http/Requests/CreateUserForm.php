<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class CreateUserForm extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->is_manager;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'        => ['required'],
            'email'       => ['required', 'email', 'unique:users,email'],
            'user_code'   => ['required', 'unique:users,user_code'],
            'password'    => ['confirmed', 'min:6'],
            'hourly_rate' => ['required', 'integer']
        ];
    }

    public function userAttributes()
    {
        return [
            'name'        => $this->name,
            'email'       => $this->email,
            'user_code'   => $this->user_code,
            'hourly_rate' => $this->hourly_rate,
            'is_manager'  => $this->is_manager,
            'password'    => Hash::make($this->password),
        ];
    }
}
