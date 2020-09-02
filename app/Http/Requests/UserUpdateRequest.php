<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest {

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
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => ['required', 'string', 'max:255',"min:5"],
            'last_name' => ['required', 'string', 'max:255',"min:5"],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['required'],
            'profil' => 'required|min:3|max:1000',
            'password' => ['confirmed'],
            'avatar' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'roles' => 'required'
        ];
    }

}

