<?php

namespace App\Http\Requests;

class CreateOperatorAccountRequest extends Request {
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
            'email'   => 'email|unique:admin,email',
            'password'   => 'required|max:13|min:6',
        ];
    }
}