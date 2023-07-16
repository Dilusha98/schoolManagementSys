<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentManagementModel extends Model
{
    use HasFactory;
    protected $table = 'student_management_models';
    protected $fillable = [
        'studentFullName',
        'studentInitials',
        'studentBirthday',
        'studentGender',
        'studentNationality',
        'guardianType',
        'guardianFullName',
        'guardianInitials',
        'guardianNIC',
        'guardianBirthday',
        'guardianEmail',
        'guardianAddress',
        'guardianPostalCode',
        'guardianOccupation',
    ];
}
