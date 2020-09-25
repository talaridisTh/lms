<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class BundleCourseRequest extends FormRequest
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
			'title' => 'required|string|max:50',
			'version' => 'required'
		];
	}
	
	public function messages() {
    	return [
    	    'dimensions' => "Οι διαστάσεις του :attribute πρέπει να είναι 600 x 400.",
    	];
	}
}
