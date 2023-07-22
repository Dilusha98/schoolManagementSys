<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class classManagement extends Model
{
    use HasFactory;
    protected $table = 'studentclass';
    protected $fillable = [
        'grade',
        'stream',
        'class',
        'medium',
        'teacher',
    ];
}
