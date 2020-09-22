<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
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
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'first_name' => ['required', 'string', 'max:255',"min:3"],
            'last_name' => ['required', 'string', 'max:255',"min:3"],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            //'cover' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'roles' => 'required'



        ];


    }

}
