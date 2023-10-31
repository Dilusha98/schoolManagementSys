<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class marks extends Model
{
    use HasFactory;
    protected $table = 'marks';
    protected $fillable = [
        'studentID',
        'subjectID',
        'class',
        'grade',
        'grade',
        'year',
        'marks',
        'semester',
    ];
}
