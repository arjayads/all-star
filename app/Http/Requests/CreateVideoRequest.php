<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateVideoRequest extends Request
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
        $rules = [
            'title' => 'required|min:3'
        ];

        if($this->segment('/admin/videos/create')){
            $rules['video'] = 'required';
        }

        return $rules;
    }
}
