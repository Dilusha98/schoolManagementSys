<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserValidationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'roleSelect'=>'required',
            'userFirstName'=>'required',
            'userLastName'=>'required',
            'userEmail'=>'required',
            'userAddress'=>'required',
            'userTelephone'=>'required',
            'UserUserName'=>'required',
            'userDOB'=>'required',
            'userGender'=>'required',
            'userPassword'=>'required',
        ];
    }
}
