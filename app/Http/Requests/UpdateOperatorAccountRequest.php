<?php

namespace App\Http\Requests;


use App\Admin;

class UpdateOperatorAccountRequest extends Request
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
        $roles = array();

        //get data request
        $operator_id = $this->get('id');
        $email = $this->get('email');

        $current_user_edited = Admin::where('id', $operator_id)->first();

        if ($email != $current_user_edited->email) {
            $roles['email'] = 'email|unique:admin,email';
        }
        $roles['password'] = 'max:13|min:6';

        return $roles;
    }
}