<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateMaterialRequest extends FormRequest
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
            'title' => 'required',
			'video_link' => 'required_if:type,Video',
			'link' => 'required_if:type,Link',
			'content' => 'required_if:type,Announcement',
        ];
	}
	
	public function messages()
	{
		return [
			"video_link.required_if" => "Το πεδίο είναι υποχρεωτικό όταν ο Tύπος είναι Video.",
			"link.required_if" => "To πεδίο είναι υποχρεωτικό όταν ο Τύπος είναι Link.",
			"content.required_if" => "To πεδίο είναι υποχρεωτικό όταν ο Τύπος είναι Ανακοίνωση."
		];
	}
}
