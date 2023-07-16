<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class editStudentDetailsRequest extends FormRequest
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
            'studentFullName'=>'Required',
            'studentInitials'=>'Required',
            'studentBirthday' => 'required|before:'.date('Y-m-d', strtotime('-5 years')),
            'studentGender'=>'Required',
            'studentNationality'=>'Required',
            'guardianType'=>'Required',
            'guardianFullName'=>'Required',
            'guardianInitials'=>'Required',
            'guardianNIC'=>'Required',
            'guardianBirthday' => 'required|before:'.date('Y-m-d', strtotime('-18 years')),
            'guardianAddress'=>'Required',
            'guardianPostalCode'=>'Required|numeric',
            'guardianOccupation'=>'Required',
            'guardianEmail'=>'email',
        ];
    }
}
