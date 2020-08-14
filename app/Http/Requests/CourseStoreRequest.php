<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CourseStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
		
		if ( Auth::user()->roles[0]->id == 1 ) {
			return true;
		}
		
		return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' 			=> 'required|string|max:50',
			'active' 		=> 'required|numeric|digits:1|gte:0|lte:1',
			'description' 	=> 'required|string|max:500'
		];
		// return [];
    }
}
