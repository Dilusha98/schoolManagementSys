<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserManagment extends Model
{
    use HasFactory;
    protected $table = 'user_managments';
    protected $fillable = [
        'role',
        'userFirstName',
        'userLastName',
        'userEmail',
        'userAddress',
        'userTelephone',
        'UserUserName',
        'userDOB',
        'userGender',
        'userPassword',
    ];
}
