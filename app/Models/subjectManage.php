<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subjectManage extends Model
{
    use HasFactory;
    protected $table = 'subject_manages';
    protected $fillable = [
        'subject',
        'description',
        '01',
        '02',
        '03',
        '04',
        '05',
        '06',
        '07',
        '08',
        '09',
        '10',
        '11',
        '12',
        '13',
    ];
}
